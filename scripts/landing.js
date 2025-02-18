const navbar = document.querySelector('nav')
const hero = document.querySelector('#home')
const housesNode = document.querySelector('.houses')
const prevBtn = document.querySelector('.prev')
const nextBtn = document.querySelector('.next')

const housesList = []
let activeIndex = 0
let interval

const anamiHomes = { lat: 10.280378611846126, lng: 123.96300678555058 }
let map, geocoder, marker

const initMap = async () => {
    (g=>{var h,a,k,p="The Google Maps JavaScript API",c="google",l="importLibrary",q="__ib__",m=document,b=window;b=b[c]||(b[c]={});var d=b.maps||(b.maps={}),r=new Set,e=new URLSearchParams,u=()=>h||(h=new Promise(async(f,n)=>{await (a=m.createElement("script"));e.set("libraries",[...r]+"");for(k in g)e.set(k.replace(/[A-Z]/g,t=>"_"+t[0].toLowerCase()),g[k]);e.set("callback",c+".maps."+q);a.src=`https://maps.${c}apis.com/maps/api/js?`+e;d[q]=f;a.onerror=()=>h=n(Error(p+" could not load."));a.nonce=m.querySelector("script[nonce]")?.nonce||"";m.head.append(a)}));d[l]?console.warn(p+" only loads once. Ignoring:",g):d[l]=(f,...n)=>r.add(f)&&u().then(()=>d[l](f,...n))})({
        key: "AIzaSyBUE_qqLPIyEb1uGZeAx6asjCid3UDr22c",
        v: "weekly",
    })

    const MAP_ID = '3bd7dad86499c826'

    const { Map } = await google.maps.importLibrary("maps")
    const { Geocoder } = await google.maps.importLibrary("geocoding")
    const { AdvancedMarkerElement } = await google.maps.importLibrary("marker");

    geocoder = new Geocoder()
    map = new Map(document.querySelector(".map"), {
        center: anamiHomes,
        zoom: 18,
        mapId: MAP_ID
    });
    marker = new AdvancedMarkerElement({
        position: anamiHomes,
        map: map,
    })
}

const moveMap = (location) => {
    let coords = location

    if (typeof location === "object" && !location.lat && !location.lng)
        alert("Invalid location format. Use an address string or { lat, lng } object.");

    if (typeof location === "string") {
        geocoder.geocode({ address: location }, (results, status) => 
            coords = status === "OK" ? results[0].geometry.location : anamiHomes
        )
    }

    map.panTo(coords)
    displayMarker(coords)
};

const displayMarker = (coords) => {
    const label = document.createElement("div");
    label.className = "marker-label";
    label.style.position = "absolute";
    label.style.background = "white";
    label.style.padding = "5px 10px";
    label.style.borderRadius = "5px";
    label.style.fontSize = "14px";
    label.style.boxShadow = "0px 2px 5px rgba(0,0,0,0.3)";
    // label.style.display = "none"; // Hidden until location is found
    document.body.appendChild(label);

    geocoder.geocode({ location: marker.position }, (results, status) => {
        if (status === "OK" && results[0]) {
            const locationName = results[0].formatted_address;

            // ✅ Update Marker Label
            label.innerText = 'hello world';
            label.style.display = "block";

            // ✅ Position Label on the Map
            const projection = map.getProjection();
            if (projection) {
                const point = projection.fromLatLngToPoint(marker.position);
                label.style.left = `${point.x}px`;
                label.style.top = `${point.y}px`;
            }
        } else {
            // label.style.display = "none";
            console.error("Geocoder failed: " + status);
        }
    });

    marker.position = coords
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
    // el.classList.add(
    //     ...(Array.isArray(className) ? 
    //         className : 
    //         className.split(" ")
    //     )
    // )
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
    const res = await fetch("/api/houses")
    const data = await res.json()

    loadHouses(data)
    initMap();
}

addEventListener("scroll", handleScroll)
addEventListener("DOMContentLoaded", handleLoad)
prevBtn.addEventListener('click', scrollPrev)
nextBtn.addEventListener('click', scrollNext)

