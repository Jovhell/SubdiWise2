const navbar = document.querySelector('nav')
const hero = document.querySelector('#home')
const housesNode = document.querySelector('.houses')
const prevBtn = document.querySelector('.prev')
const nextBtn = document.querySelector('.next')
const controls = document.querySelector('.controls')

const housesList = []
let activeIndex = 0
let interval

let PLACES, map, geocoder, marker, placesService, label, directionsService, directionsRenderer

const displayAccordions = () => {
    for(let [key, place] of Object.entries(PLACES)) {
        const item = createNode({ element: "div", className: "item"})
        const title = createNode({ element: "div", className: "title"})
        const header = createNode({ element: "h5", className: "header", innerText: place.businessName })
        const subheader = createNode({ element: "p", className: "subheader", innerText: place.type })
        const content = createNode({ element: "div", className: "content", innerText: place.content })

        title.setAttribute("data-key", key)

        title.appendChild(header)
        title.appendChild(subheader)
        item.appendChild(title)
        item.appendChild(content)

        controls.appendChild(item)
    }

    controls.querySelectorAll(".title").forEach(header => {
        header.addEventListener("click", function() {
            const item = this.parentElement;
            const isActive = item.classList.contains("active");

            controls.querySelectorAll(".item").forEach(i => i.classList.remove("active"));

            if (!isActive) {
                item.classList.add("active");
            }

            moveMap(header.dataset.key)
        });
    });
}

const initMap = async () => {
    (g=>{var h,a,k,p="The Google Maps JavaScript API",c="google",l="importLibrary",q="__ib__",m=document,b=window;b=b[c]||(b[c]={});var d=b.maps||(b.maps={}),r=new Set,e=new URLSearchParams,u=()=>h||(h=new Promise(async(f,n)=>{await (a=m.createElement("script"));e.set("libraries",[...r]+"");for(k in g)e.set(k.replace(/[A-Z]/g,t=>"_"+t[0].toLowerCase()),g[k]);e.set("callback",c+".maps."+q);a.src=`https://maps.${c}apis.com/maps/api/js?`+e;d[q]=f;a.onerror=()=>h=n(Error(p+" could not load."));a.nonce=m.querySelector("script[nonce]")?.nonce||"";m.head.append(a)}));d[l]?console.warn(p+" only loads once. Ignoring:",g):d[l]=(f,...n)=>r.add(f)&&u().then(()=>d[l](f,...n))})({
        key: "AIzaSyBUE_qqLPIyEb1uGZeAx6asjCid3UDr22c",
        v: "weekly",
    })

    const MAP_ID = '3bd7dad86499c826'

    const { Map } = await google.maps.importLibrary("maps")
    const { Geocoder } = await google.maps.importLibrary("geocoding")
    const { AdvancedMarkerElement } = await google.maps.importLibrary("marker");
    const { PlacesService } = await google.maps.importLibrary("places");
    const { DirectionsService, DirectionsRenderer } = await google.maps.importLibrary("routes")

    geocoder = new Geocoder()
    map = new Map(document.querySelector(".map"), {
        zoom: 18,
        mapId: MAP_ID
    });
    marker = new AdvancedMarkerElement({
        map: map,
    })
    label = createNode({ element: 'div', className: 'marker-label'})
    placesService = new PlacesService(map)
    directionsService = new DirectionsService()
    directionsRenderer = new DirectionsRenderer()

    directionsRenderer.setMap(map)
    marker.content.classList.add("bounce")

    moveMap(PLACES.anamiHomes)
    displayAccordions()
}

const showRoute = (origin, destination) => {
    if (
        JSON.stringify({lat: origin.lat, lng: origin.lng}) === 
        JSON.stringify({lat: destination.lat(), lng: destination.lng()})
    ) {
        map.setZoom(18)
        directionsRenderer.setDirections({ routes: [] })
        return
    }

    const request = {
        origin: origin,
        destination: destination,
        travelMode: google.maps.TravelMode.DRIVING, // Change to WALKING, BICYCLING, or TRANSIT
    };

    directionsService.route(request, (result, status) => {
        if (status === google.maps.DirectionsStatus.OK) {
            directionsRenderer.setDirections(result);

            directionsRenderer.setOptions({ 
                suppressMarkers: true, 
                polylineOptions: {
                    strokeColor: '#47663B',
                    strokeWeight: 6
                }
            });
        } else {
            console.error("Directions request failed:", status);
        }
    })
}

const moveMap = async (location) => {
    let coords = location

    if (typeof location === "object" && !location.lat && !location.lng)
        alert("Invalid location format. Use an address string or { lat, lng } object.");

    if (typeof location === "string") {
        coords = PLACES[location]
    }

    const place = await getPlace(coords)
    
    map.panTo(place.geometry.location)

    google.maps.event.addListenerOnce(map, 'idle', () => {
        displayMarker(place.geometry.location)
        displayLabel(place.name)

        showRoute(PLACES.anamiHomes, place.geometry.location)
    });

    google.maps.event.addListener(map, 'zoom_changed', () => {
        displayLabel(label.innerText)
    });
}

const getPlace = async coords => {
    return new Promise((resolve, reject) => {
        placesService.nearbySearch({ location: coords, radius: 50}, (results, status) => {
            if(status === "OK" && results.length > 0) {
                const place = results.filter(place => place.name.includes(coords.businessName))[0]
                resolve(place)
            } else {
                reject("Place not found at getPlace()")
            }
        })

    })
}

const displayMarker = (coords) => {
    marker.content.style.display = 'none'
    marker.position = coords
    setTimeout(() => {
        marker.content.style.display = 'block'
    }, 50)
}

const displayLabel = (text) => {
    const markerParent = marker.content.parentElement
    const zoomLevel = map.getZoom()

    if (zoomLevel <= 15) {
        if (markerParent.contains(label)) {
            markerParent.removeChild(label);
        }
        return;
    }

    markerParent.appendChild(label)
    label.innerText = text
}

const displayHouse = () => {
    const currentHouse = housesList[activeIndex]
    housesNode.appendChild(currentHouse)
}

const scrollPrev = () => {
    const currentHouse = housesList[activeIndex]
    activeIndex = (activeIndex - 1 + housesList.length) % housesList.length;
    const prevHouse = housesList[activeIndex]
    
    prevHouse.style.transform = 'translateX(-100%)'
    prevHouse.style.position = 'absolute'
    displayHouse()

    requestAnimationFrame(() => {
        currentHouse.style.transform = "translateX(100%)"
        prevHouse.style.transform = "translateX(0%)"

        setTimeout(() => {
            housesNode.removeChild(currentHouse)
        }, 500)
    })
}

const scrollNext = () => {
    const currentHouse = housesList[activeIndex]
    activeIndex = (activeIndex + 1) % housesList.length;
    const nextHouse = housesList[activeIndex]

    nextHouse.style.transform = 'translateX(100%)'
    nextHouse.style.position = 'absolute'
    displayHouse()
    
    requestAnimationFrame(() => {
        requestAnimationFrame(() => {
            currentHouse.style.transform = "translateX(-100%)"
            nextHouse.style.transform = "translateX(0%)"
    
            setTimeout(() => {
                housesNode.removeChild(currentHouse)
            }, 500)
        })
    })
}

const slideshow = () => {
    stopSlideshow()
    interval = setInterval(() => {
        scrollNext()
    }, 3000)
}

const stopSlideshow = () => {
    clearInterval(interval)
}

const loadHouses = (houses) => {
    houses.forEach(house => {
        const listItem = createNode({ element: "li", className: "house" })
        
        const details = createNode({ element: "div", className: "details" })
        const picture = createNode({ element: "div", className: "picture" })
        
        const houseType = createNode({ element: "div", className: "house-type" })
        const metrics = createNode({ element: "div", className: "metrics" })
        const detailsBtn = createNode({ element: "a" , className: "details-btn", innerText: "View Details" })
        const arrowIcon = createNode({ element: "img", src: "assets/next.svg" })

        const name = createNode({ element: "div", className: "name", innerText: house.name })
        const type = createNode({ element: "div", className: "type", innerText: house.type })

        const background = createNode({ element: "div", className: "background" })
        const houseImg = createNode({ element: "img", src: `assets/${house.name}.png` })
        
        house.metrics.forEach(m => {
            const metric = createNode({ element: "div", className: "metric" })
            const data = createNode({ element: "div", className: "data", innerText: m.data })
            const dataType = createNode({ element: "div", className: "data-type", innerText: m.dataType })

            metric.appendChild(data)
            metric.appendChild(dataType)
            metrics.appendChild(metric)
        })

        houseType.appendChild(name)
        houseType.appendChild(type)
        detailsBtn.appendChild(arrowIcon)

        details.appendChild(houseType)
        details.appendChild(metrics)
        details.appendChild(detailsBtn)

        picture.appendChild(background)
        picture.appendChild(houseImg)

        listItem.appendChild(details)
        listItem.appendChild(picture)

        // housesNode.appendChild(listItem)
        housesList.push(listItem)
    });

    displayHouse()
    slideshow()
}

const createNode = ({ 
    element, 
    className = "", 
    innerText = "", 
    src = "" 
}) => {
    const el = document.createElement(element)
    el.className = className
    el.innerText = innerText
    el.src = src

    return el
}

const handleScroll = e => {
    const heroBottom = hero.getBoundingClientRect().bottom

    heroBottom <= 0 ?
        navbar.classList.add("scrolled") :
        navbar.classList.remove("scrolled")
}

const handleLoad = async () => {
    const [houses, places] = await Promise.all([
        fetch("/api/houses").then(res => res.json()),
        fetch("/api/places").then(res => res.json())
    ]);
    
    PLACES = places

    loadHouses(houses)
    initMap();
}

addEventListener("scroll", handleScroll)
addEventListener("DOMContentLoaded", handleLoad)
prevBtn.addEventListener('click', scrollPrev)
nextBtn.addEventListener('click', scrollNext)

