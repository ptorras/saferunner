import requests
import gmaps
import googlemaps
key="Put your key"
url_function="put your function url"
def main():
    x=requests.get(url_function)
    print (x)

#import list

if __name__ == "__main__":
    # execute only if run as a script
    main()
