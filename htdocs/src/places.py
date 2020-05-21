# -*- coding: utf-8 -*-

import googlemaps
import gmaps
from datetime import datetime
from secret import key
import time
#import list

gmaps=googlemaps.Client(key=key)

# TODO: get this from client
now = datetime.now()
origin = (41.620748, 2.295780)
destination = origin  # (41.622039, 2.296327)
distance = "10000"# radius meters
date = ""
time = ""
pace = ""
city = ""

#waypoints=list()
waypoints=[]

places_result  = gmaps.places_nearby(origin, distance , open_now =False , type = 'park')

#types URL=   developers.google.com/places/web-service/supported_types

time.sleep(3)

#get the next 20 results
#place_result  = gmaps.places_nearby(page_token = places_result['next_page_token'])

for place in places_result['results']:
    # define the place id, needed to get place details. Formatted as a string.
    waypoints.append(place['location'])
    # format URL developers.google.com/places/web-service/details
    



