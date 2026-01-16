import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import path from 'path';
import { copyFileSync, mkdirSync, existsSync } from 'fs';
import { resolve } from 'path';

 export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/assets/sass/app.scss',
                'resources/js/app.js'
            ],
            refresh: true,
        }),
        vue(),
        {
            name: 'copy-legacy-files',
            apply: 'build',
            writeBundle() {

                // Copy admin CSS files to build directory
                const cssFiles = [
                    'admin/css/style4.css',
                    'admin/css/style.css', 
                    'admin/css/bar.css',
                    'admin/css/widgets.css'
                ];
                
                cssFiles.forEach(file => {
                    const src = resolve(__dirname, `public/${file}`);
                    const destDir = resolve(__dirname, `public/build/${path.dirname(file)}`);
                    
                    if (existsSync(src)) {
                        if (!existsSync(destDir)) {
                            mkdirSync(destDir, { recursive: true });
                        }
                        copyFileSync(src, resolve(destDir, path.basename(file)));
                        console.log(`Copied ${file} to build directory`);
                    }
                });


                // Copy admin JS files that aren't part of the module system
                const adminFiles = ['admin/js/main.js', 'admin/js/typehead.js'];
                
                adminFiles.forEach(file => {
                    const src = resolve(__dirname, `public/${file}`);
                    const destDir = resolve(__dirname, `public/build/${path.dirname(file)}`);
                    
                    if (existsSync(src)) {
                        if (!existsSync(destDir)) {
                            mkdirSync(destDir, { recursive: true });
                        }
                        copyFileSync(src, resolve(destDir, path.basename(file)));
                        console.log(`Copied ${file} to build directory`);
                    }
                });

                // Copy Font Awesome fonts
                const fontsDir = resolve(__dirname, 'public/build/webfonts');
                if (!existsSync(fontsDir)) {
                    mkdirSync(fontsDir, { recursive: true });
                }
                
                const fontFiles = [
                    'fa-solid-900.woff2',
                    'fa-solid-900.ttf',
                    'fa-regular-400.woff2',
                    'fa-regular-400.ttf',
                    'fa-brands-400.woff2',
                    'fa-brands-400.ttf',
                ];
                
                fontFiles.forEach(file => {
                    const src = resolve(__dirname, `node_modules/@fortawesome/fontawesome-free/webfonts/${file}`);
                    const dest = resolve(fontsDir, file);
                    if (existsSync(src)) {
                        copyFileSync(src, dest);
                    }
                });


                // Copy Froala Editor files  to be removed with all froala files

                // const froalaDir = resolve(__dirname, 'public/build/froala');
                // if (!existsSync(froalaDir)) {
                //     mkdirSync(froalaDir, { recursive: true });
                // }

                // const froalaFiles = [
                //     'froala_editor.pkgd.min.js',
                //     'froala_editor.pkgd.min.css'
                // ];

                // froalaFiles.forEach(file => {
                //     const src = resolve(__dirname, `node_modules/froala-editor/${file.includes('.js') ? 'js' : 'css'}/${file}`);
                //     const dest = resolve(froalaDir, file);
                //     if (existsSync(src)) {
                //         copyFileSync(src, dest);
                //     }
                // });

                // Copy CKEditor files
                const ckeditorDir = resolve(__dirname, 'public/build/ckeditor');
                if (!existsSync(ckeditorDir)) {
                    mkdirSync(ckeditorDir, { recursive: true });
                }

                const ckeditorFiles = [
                    'ckeditor.js',
                    'ckeditor.js.map'
                ];

                ckeditorFiles.forEach(file => {
                    const src = resolve(__dirname, `node_modules/@ckeditor/ckeditor5-build-classic/build/${file}`);
                    const dest = resolve(ckeditorDir, file);
                    if (existsSync(src)) {
                        copyFileSync(src, dest);
                        console.log(`Copied CKEditor ${file} to build directory`);
                    }
                });

                // Copy CKEditor translations
                const ckeditorTranslationsDir = resolve(__dirname, 'public/build/ckeditor/translations');
                if (!existsSync(ckeditorTranslationsDir)) {
                    mkdirSync(ckeditorTranslationsDir, { recursive: true });
                }

                const translationFile = 'fr.js';
                const translationSrc = resolve(__dirname, `node_modules/@ckeditor/ckeditor5-build-classic/build/translations/${translationFile}`);
                const translationDest = resolve(ckeditorTranslationsDir, translationFile);
                if (existsSync(translationSrc)) {
                    copyFileSync(translationSrc, translationDest);
                    console.log(`Copied CKEditor translation ${translationFile}`);
                }

                // Copy admin images
                const imagesDir = resolve(__dirname, 'public/build/admin/images');
                if (!existsSync(imagesDir)) {
                    mkdirSync(imagesDir, { recursive: true });
                }
                
                const imageFiles = [
                    'Preloader_2.gif',
                    'licence_image.jpg',
                    'faviconlogo.ico'
                ];
                
                imageFiles.forEach(file => {
                    const src = resolve(__dirname, `public/admin/images/${file}`);
                    const dest = resolve(imagesDir, file);
                    if (existsSync(src)) {
                        copyFileSync(src, dest);
                    }
                });

            }
        }
    ],

    resolve: {
        alias: {
            '@': path.resolve(__dirname, 'resources/assets/js'),
            '~': path.resolve(__dirname, 'node_modules'), 
            vue: 'vue/dist/vue.esm-bundler.js',
        },
    },

    build: {
        outDir: 'public/build',
        manifest: 'manifest.json',
        sourcemap: false,

        rollupOptions: {
            output: {
                assetFileNames: (assetInfo) => {
                    // Fonts to webfonts directory
                    if (/\.(woff2?|eot|ttf|otf)$/i.test(assetInfo.name)) {
                        return `webfonts/[name][extname]`;
                    }
                    // Images
                    if (/\.(png|jpe?g|svg|gif|tiff|bmp|ico)$/i.test(assetInfo.name)) {
                        return `images/[name][extname]`;
                    }
                    // CSS
                    if (/\.css$/i.test(assetInfo.name)) {
                        return `css/[name][extname]`;
                    }
                    return `assets/[name][extname]`;
                },
                entryFileNames: 'js/[name].js',
                chunkFileNames: 'js/[name].js',
            },

        },
    },

    optimizeDeps: {
        include: [
            'jquery', 
            'bootstrap', 
            'datatables.net-bs5',
            '@fullcalendar/core',
            '@fullcalendar/vue3',
            '@fullcalendar/daygrid',
            '@fullcalendar/timegrid',
            '@fullcalendar/interaction',
            '@fullcalendar/list',
            '@fullcalendar/bootstrap5',
            '@fullcalendar/resource-timeline',
            '@fullcalendar/moment',
            '@fullcalendar/rrule',
            '@ckeditor/ckeditor5-build-classic'
        ],
    },
});