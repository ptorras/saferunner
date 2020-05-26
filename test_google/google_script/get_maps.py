import googlemaps
import gmaps
from datetime import datetime
import json
import cgi
from flask import abort
import os
form = cgi.FieldStorage()
print('form')
key=os.environ.get('KEY')
gmap = googlemaps.Client(key=key)
gmaps.configure(api_key=key)
def get_maps(request):
    request_args = request.args
    if request.method == 'OPTIONS':
        headers = {
                'Access-Control-Allow-Origin': '*',
                'Access-Control-Allow-Methods': 'POST',
                'Access-Control-Allow-Headers': 'Content-Type',
                'Access-Control-Max-Age': '3600'
            }
        return ('', 204, headers)
    headers = {
        'Access-Control-Allow-Origin': '*'
    }
    # TODO: get this from client
    now = datetime.now()
    origin = (41.620748, 2.295780)
    destination = origin  # (41.622039, 2.296327)
    distance = ""
    date = ""
    time = ""
    pace = ""
    city = ""

    # TODO: choose safest 3 waypoints
    waypoints = [(41.622024, 2.297400), (41.620972, 2.296649), (41.621285, 2.296906)]

    directions_result = gmap.directions(origin, destination, waypoints=waypoints, mode='walking', departure_time=now)[0]


    print(json.dumps(directions_result, indent=4))
    print("Number of legs {}".format(len(directions_result)))

    # fig.add_layer(directions_result)
    # embed_minimal_html('export.html', views=[fig])

    # Data structure to save path points coords
    path_coords = []
    for step in directions_result['legs']:
        path_coords.append([step['start_location']['lat'], step['start_location']['lng']])
        path_coords.append([step['end_location']['lat'], step['end_location']['lng']])

    # Visual check
    for n, point in enumerate(path_coords):
        print("Step {}".format(n))
        print("Latitude: {} \t Longitude: {}".format(point[0], point[1]))


    # TODO: add db entry


    """
    for step in directions_result["legs"]:
        print(step['start_location'])
    for step in directions_result["legs"]:
        print(step['end_location'])
    for step in directions_result["legs"]:
        for s in (step['steps']):
            print(s["html_instructions"])
    """
    return("ok",200,headers)