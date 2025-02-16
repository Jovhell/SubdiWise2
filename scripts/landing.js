const navbar = document.querySelector('nav')
const hero = document.querySelector('#home')
const housesNode = document.querySelector('.houses')
const prevBtn = document.querySelector('.prev')
const nextBtn = document.querySelector('.next')

const housesList = []
let activeIndex = 0
let interval

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
        currentHouse.style.transform = "translateX(-100%)"
        nextHouse.style.transform = "translateX(0%)"

        setTimeout(() => {
            housesNode.removeChild(currentHouse)
        }, 500)
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
}

addEventListener("scroll", handleScroll)
addEventListener("DOMContentLoaded", handleLoad)
prevBtn.addEventListener('click', scrollPrev)
nextBtn.addEventListener('click', scrollNext)