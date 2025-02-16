const navbar = document.querySelector('nav')
const hero = document.querySelector('#home')
const housesNode = document.querySelector('.houses')

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

        housesNode.appendChild(listItem)
    });
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

    console.log(data)
    loadHouses(data)
}

addEventListener("scroll", handleScroll)
addEventListener("DOMContentLoaded", handleLoad)