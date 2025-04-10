# Capital of Business Theme

This WordPress theme uses Laravel Mix to compile and optimize CSS and JS assets for improved performance and better asset management.

## Requirements

- **Node.js & npm:** To run Laravel Mix.
- **PHP & WordPress:** To run the theme.
- **Local Development Environment:** e.g., WAMP, XAMPP, or similar.


## Installation & Compilation Steps

1. **Install Node.js Dependencies:**

   Open your terminal in the project root and run:
   ```bash
   npm install
Compile Assets Using Laravel Mix:

For development (without versioning):

   ```bash
npm run dev
   ```
For production (with cache busting via versioning):


   ```bash
npm run prod
 ```
After running the command, you will find the compiled files in the dist folder.

Using Compiled Assets in the Theme
The mix-manifest.json file and the mix_asset() helper function (defined in your theme’s functions.php) are used to correctly reference the compiled assets.

Ensure that your theme calls the compiled files (e.g., all.css and all.js) instead of individual asset files for better performance.

Troubleshooting
File Path Errors:
Verify that the paths in webpack.mix.js match your project structure. Update them if files have been moved.

Cache Issues:
If updates to your assets are not reflected on the site, ensure you run npm run prod to generate a new version with updated hash values.

Additional Information
To add new files or change the order of compilation, modify the arrays in the mix.styles() and mix.scripts() sections in webpack.mix.js.

For more details on Laravel Mix, refer to the official Laravel Mix documentation.

This README should help anyone setting up the theme to understand how to install dependencies, compile assets, and integrate the compiled files into the WordPress theme.


---