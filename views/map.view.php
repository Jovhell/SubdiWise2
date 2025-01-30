<?php require(base_path('views/partials/head.php')) ?>
<body>
    <div class="container">
        <div class="tooltip">
            <div class="owner"></div>
            <div class="location"></div>
        </div>
        <?php require(base_path('assets/Bearing.svg')) ?>
    </div>

<script>
    const paths = document.querySelectorAll('[data-block]')
    let residents;

    async function init() {
        await getResidents()

        addHover()
    }

    async function getResidents() {
        const res = await fetch(`data/residence.json`)
        const data = await res.json()

        residents = data
    }

    function addHover() {
        console.log(residents)
        paths.forEach(path => {
            path.addEventListener('mouseover', (e) => {
                const tooltip = document.querySelector(".tooltip")
                const owner = document.querySelector(".owner")
                const location = document.querySelector(".location")
                const block = path.getAttribute('data-block')
                const lot = path.getAttribute('data-lot').split('-')[0]
    
                const { block: blk, lot: lt, homeOwner } = residents.find(resident => resident.block == block && resident.lot.includes(lot))
                
                const { clientX, clientY } = e
                
                tooltip.style.display = 'block'
                owner.innerText = homeOwner
                location.innerText = `Block ${blk} Lot ${lt}`

                document.querySelector(':root').style.setProperty('--x', `${clientX}px`)
                document.querySelector(':root').style.setProperty('--y', `${clientY}px`)
            })

            path.addEventListener('mouseleave', () => {
                const tooltip = document.querySelector(".tooltip")

                tooltip.style.display = 'none'
            })
        })
    }

    init()
</script>
<?php require 'partials/foot.php' ?>