export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/sass/app.scss', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    build: {
        manifest: true,
        outDir: 'public/build',
        rollupOptions: {
            input: 'resources/js/app.js', // asegúrate de que el archivo sea correcto
        },
    },
    base: '/', // Asegúrate de que esto sea correcto para tu entorno
});
