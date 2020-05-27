import googlemaps
import gmaps
import json
import os
import math
import random
from datetime import datetime, timedelta
import sqlalchemy


def get_route(request):

    data = request.get_json()

    db = sqlalchemy.create_engine(
        sqlalchemy.engine.url.URL(
            drivername="mysql+pymysql",
            username="root",
            password=os.environ.get('SQL_PASSWORD'),
            database="saferunnerDB",
            query={"unix_socket": "/cloudsql/{}".format("balmy-virtue-277911:europe-west3:saferunner-sql")},
        ),
        pool_recycle=1800,  # 30 minutes
    )

    key=os.environ.get('KEY')

    R = 6373.0  # Earth radius

    gmap = googlemaps.Client(key=key)
    gmaps.configure(api_key=key)

    # TODO: get this from client
    now = datetime.now()
    origin = (41.620748, 2.295780)
    origin = (41.564166, 1.999159)

    distance = 5000
    places_radius = distance/(math.pi)
    date = datetime.now().strftime("%Y-%m-%d")
    hour1 = datetime.now().strftime("%H:%M:%S")
    # TODO improvement: calcular el temps a partir del pace
    hour2 = (datetime.now() + timedelta(hours=1)).strftime("%H:%M:%S")
    pace = ""
    city = ""

    # Get interesting points
    parks = gmap.places_nearby(origin, places_radius, type='park')
    stadiums = gmap.places_nearby(origin, places_radius, open_now=False, type='stadium')
    attraction = gmap.places_nearby(origin, places_radius, open_now=False, type='tourist_attraction')
    natural = gmap.places_nearby(origin, places_radius, open_now=False, type='natural_feature')

    possible_waypoints = []

    for parc in parks['results']:
        info = {'lat': parc['geometry']['location']['lat'], 'lng': parc['geometry']['location']['lng'],
                'id': parc['id'], 'name': parc['name']}
        possible_waypoints.append(info)

    for stadium in stadiums['results']:
        info = {'lat': stadium['geometry']['location']['lat'], 'lng': stadium['geometry']['location']['lng'],
                'id': stadium['id'], 'name': stadium['name']}
        possible_waypoints.append(info)

    for attr in attraction['results']:
        info = {'lat': attr['geometry']['location']['lat'], 'lng': attr['geometry']['location']['lng'],
                'id': attr['id'], 'name': attr['name']}
        possible_waypoints.append(info)

    for nat in natural['results']:
        info = {'lat': nat['geometry']['location']['lat'], 'lng': nat['geometry']['location']['lng'],
                'id': nat['id'], 'name': nat['name']}
        possible_waypoints.append(info)


    # If not enough places, generate random points
    while len(possible_waypoints) < 3:
        # create random points
        r = places_radius/(4*111300)        # radius conversion to degrees (also by 4 to reduce random area)
        u = random.random()
        v = random.random()
        w = r * math.sqrt(u)
        t = 2 * math.pi * v
        x = w * math.cos(t)
        y = w * math.sin(t)
        x = x / math.cos(origin[1])
        lat = x + origin[0]  # TODO
        lng = y + origin[1]
        info = {'lat': lat, 'lng': lng, 'id': 'RAND', 'name': 'RAND_POINT', 'count': 0}
        possible_waypoints.append(info)
        print((lat, lng))
        pass

    for point in possible_waypoints:
        print(point['name'])

    # TODO: Sort points by coincidences at same time

    with db.connect() as conn:
        for wp in possible_waypoints:
            stmt = sqlalchemy.text(
                "SELECT COUNT(*) FROM punt WHERE id_waypoint = :id "
                "AND datediff(data, :data) = 0 "
                "AND CAST(data as time) between :h1 and :h2"
            )

            punts = conn.execute(stmt, id=wp['id'], data=date, h1=hour1, h2=hour2).fetchall()
            wp['count'] = punts[0][0]
        conn.close()

    sorted_waypoints = sorted(possible_waypoints, key=lambda d: d['count'])
    return str(sorted_waypoints)

    # Select waypoints for the route
    waypoints = []
    total_distance = 0
    i = 0
    while (len(waypoints) < 3 or total_distance >= distance*1.3) and i < len(sorted_waypoints):
        point = sorted_waypoints[i]
        if i == 0:
            total_distance += gmap.distance_matrix(origin, (point['lat'], point['lng']),
                                                   mode='walking')['rows'][0]['elements'][0]['distance']['value']
            waypoints.append((point['lat'], point['lng']))
        else:
            if len(waypoints) == 2:
                org = (point['lat'], point['lng'])
                dest = origin
            else:
                org = waypoints[-1]
                dest = (point['lat'], point['lng'])

            dist = gmap.distance_matrix(org, dest, mode='walking')['rows'][0]['elements'][0]['distance']['value']
            if total_distance + dist <= total_distance*1.3:    # variation possibility
                total_distance += dist
                waypoints.append((point['lat'], point['lng']))
        i += 1

    # Fill with random if not full and distance not covered
    while len(waypoints) < 3 and distance*0.7 >= total_distance >= distance*1.3:
        rand_choice = random.randint(0, len(sorted_waypoints))
        waypoints.append(sorted_waypoints[rand_choice])

    print(waypoints)

    directions_result = gmap.directions(origin, origin, waypoints=waypoints, mode='walking', departure_time=now)[0]
    print(json.dumps(directions_result, indent=4))
    print("Number of legs {}".format(len(directions_result)))

    # Data structure to save path points coords
    path_coords = []
    path_coords.append(directions_result['legs'][0]['start_location'].copy())
    for step in directions_result['legs']:
        path_coords.append(step['end_location'].copy())

    # Visual check
    for n, point in enumerate(path_coords):
        print("Step {}".format(n))
        print("Latitude: {} \t Longitude: {}".format(point['lat'], point['lng']))


    return json.dumps(path_coords)