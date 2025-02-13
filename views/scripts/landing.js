const navbar = document.querySelector('nav')
const hero = document.querySelector('#home')
const carousel = document.querySelector('.houses-carousel')

const handleScroll = e => {
    const heroBottom = hero.getBoundingClientRect().bottom

    heroBottom <= 0 ?
        navbar.classList.add("scrolled") :
        navbar.classList.remove("scrolled")
}

addEventListener("scroll", handleScroll)