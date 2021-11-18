module.exports = {
    mode: 'jit',
    purge: {
        content: [
            './resources/**/*.antlers.html',
            './resources/**/*.blade.php',
            './content/**/*.md',
            './resources/**/*.vue',
            './resources/**/*.js',
            './content/**/*.md',
            './content/**/*.yaml'
        ]
    },
    // important: true,
    theme: {
        extend: {
            colors: {
                primary: "var(--color-primary)",
                'primary-dark': "var(--color-primary-dark, var(--color-primary))",
                secondary: "var(--color-secondary)",
                tertiary: "var(--color-tertiary)",
                quartenary: "var(--color-quartenary)",
                quinary: "var(--color-quinary)",
                textmain: "var(--color-text-main)",
                lightgray: "var(--color-lightgray)",
                sand: "var(--color-sand)",
            },
            inset: {
                'screen': '100vh',
            }
        },
    },
    variants: {},
    plugins: [],
}
