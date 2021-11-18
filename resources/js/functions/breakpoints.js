// Set this to be your projects breakpoints
const sizes = {
    sm: 640,
    md: 768,
    lg: 1024,
    xl: 1280,
    "2xl": 1536,
}

const isAbove = {}

Object.entries(sizes).forEach(([size, val]) => {
    isAbove[size] = window.matchMedia(`(min-width: ${val}px)`)
})

export { sizes, isAbove }
