module.exports = {
    purge: ["./resources/**/*.blade.php", "./resources/**/*.js"],
    darkMode: false, // or 'media' or 'class'
    theme: {
        extend: {
            backgroundSize: {
                full: "100% 100%"
            }
        }
    },
    variants: {
        extend: {}
    },
    plugins: []
};
