# -*- coding: utf-8 -*-
#import list
import googlemaps
import gmaps
from datetime import datetime
from flask import abort
import os

key=os.environ.get('KEY')
gmaps=googlemaps.Client(key=key
)
def get_places(request):
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
    origin = (41.620748, 2.295780)
    distance = "10000"# radius meters

    #waypoints=list()
    waypoints=[]

    places_result  = gmaps.places_nearby(origin, distance , open_now =False , type = 'park')
    print("place")


    #get the next 20 results
    #place_result  = gmaps.places_nearby(page_token = places_result['next_page_token'])
    for place in places_result['results']:
        print(place)
        waypoints.append(place["geometry"]["location"])
        # define the place id, needed to get place details. Formatted as a string.
        # format URL developers.google.com/places/web-service/details
    way=str(waypoints)
    print(request_args)
    return(way,200,headers)