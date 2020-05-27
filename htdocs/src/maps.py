import googlemaps
import gmaps
from datetime import datetime
from ipywidgets.embed import embed_minimal_html
import json
from secret import key
import cgi
import math
import random



form = cgi.FieldStorage()

R = 6373.0  # Earth radius

gmap = googlemaps.Client(key=key)
gmaps.configure(api_key=key)

# TODO: get this from client
now = datetime.now()
origin = (41.620748, 2.295780)
origin = (41.564166, 1.999159)

distance = 5000
places_radius = distance/(math.pi)
date = ""
time = ""
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
    info = {'lat': lat, 'lng': lng, 'id': 'RAND', 'name': 'RAND_POINT'}
    possible_waypoints.append(info)
    print((lat, lng))
    pass

for point in possible_waypoints:
    print(point['id'], type(point['id']))

# TODO: Sort points by coincidences at same time
sorted_waypoints = possible_waypoints

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

print(json.dumps(path_coords))
# TODO: add db entry

