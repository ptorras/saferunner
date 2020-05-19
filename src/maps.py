import googlemaps
import gmaps
from datetime import datetime
from ipywidgets.embed import embed_minimal_html
import json
from secret import key


gmap = googlemaps.Client(key=key)
gmaps.configure(api_key=key)
now = datetime.now()
origin = (41.620748, 2.295780)
destination = (41.622039, 2.296327)
waypoints = [(41.622024, 2.297400), (41.620972, 2.296649), (41.621285, 2.296906)]
fig = gmaps.figure()

directions_result = gmap.directions(origin, destination, waypoints=waypoints, mode='walking', departure_time=now)[0]


print(json.dumps(directions_result, indent=4))
print("Number of legs {}".format(len(directions_result)))

fig.add_layer(directions_result)
embed_minimal_html('export.html', views=[fig])
for step in directions_result["legs"]:
    print(step['start_location'])
for step in directions_result["legs"]:
    print(step['end_location'])
for step in directions_result["legs"]:
    for s in (step['steps']):
        print(s["html_instructions"])
