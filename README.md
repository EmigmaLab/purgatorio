# Purgatorio Dev Plugin

## About

Various helper functions and classes for faster theme development.

## Changelog
See [changelog](CHANGELOG.md)

## Features

### Widgets & Sidebars
- `/includes/widgets/widgets.php`

  - Sidebar Hero Static
  - Sidebar Homepage Widgets (1/2)
  - Sidebar Header Right
  - Sidebar Footer Top Widget
  - Sidebar Footer Widgets (1/4)
  - Sidebar Footer Bottom Widget
  - Widget Business card
  - Widget Dynamic banner (for each post)
  - Widget Featured item banner
  - Widget Language switcher
  - Widget Login form
  - Widget Side navigation
  - Widget Top banner item

### Hooks
- `/includes/security.php`

  - Clean up wp_head() from unused or unsecure stuff
  - Removes the generator tag with WP version numbers
  - Show less info to users on failed login for security (Will not let a valid username be known)

- `includes/global-init.php`

  - Update Site Address (URL) & Search Engine Visibility options
  - Theme init actions - add excerpt to pages & increase var_dump display
  - Add Meta Tags in Header - IE8 support for HTML5
  - Enqueue theme scripts & styles - Remove Open Sans from frontend which is added by WP itself
  - Sets up theme defaults and registers support for various WordPress features - post-thumbnails, post-formats
  - Custom font sizes on WYSIWYG
  - Modify admin menu - remove some items
  - Remove Rev Slider Metabox
  - Adds custom classes to body - environment, language
  - Disable premium plugins update notification - Rev slider, Visual composer
  - Add additional data to Yoast's SEO JSON-LD output - Author & Publisher ID for website
  - Yoast SEO breadcrumbs modifications for single pages
  - Resizing all image media files on upload to 1920
  - Custom Page Columns - Display page template PHP file location

### Helper Functions
- `/includes/global-functions.php`

  - Get plugin option value
  - Get theme option value
  - Determine environment - dev / prod
  - Local var_dump - output visible only to administrators
  - Get post type years archive
  - Group posts by month
  - Get page template for pre-selected CPT
  - Get archive page template
  - Get archive page template title
  - Get archive page template content
  - Is date format
  - Get i18 formatted date
  - Pretty URL
  - Extract URL from string
  - Generate URL with GET parameters
  - Get title statically
  - Get taxonomy title
  - Get file size
  - Get file ID by URL
  - Check if file exists in uploads folder

- `/includes/i18n.php`

  - Get current language using Polylang or WPML
  - Get translated post using Polylang or WPML
  - Get translated term using Polylang or WPML

- `/includes/seo.php`

  - Required hatom microdata - Author & modified date
  - Outputs the JSON LD code in a valid JSON+LD wrapper
  - Prepare JSON+LD schema for software application

### Queries
- `/includes/class-queries.php`
- `global $pg_query`

  - Get latest posts
  - Get posts by year
  - Get posts from specific period
  - Get posts by search parameter (title, content, excerpt)
  - Get posts by taxonomy
  - Get children posts
  - Get posts filtered by meta key
  - Get event based post
  - Get date based post
  - Get taxonomy term's posts
  - Get posts sorted by term

### Google Maps
- `/gmaps/class-gmaps.php`
- `global $pg_gmaps`
- Google maps shortcode `[pg_gmaps id=gmaps-container cpt=page height=400px]`

  - Get post geolocation - By coordinated or by address
  - Get coordinates from address - Google API request
  - Create array of locations with valid geo data
  - Populate map with array of location - markers
  - Marker clustering
  
### Attachments
- `/gmaps/class-attachments.php`
- `global $pg_attachments`
- Attachments shortcode `[pg_attachments post_id=123 title=Downloads]`

### JavaScript
- `/assets/js/purgatorio.js`
- Usage:
  - Initialize in your theme js: `var pg = $.cantica.purgatorio();`
  - Call desired methods `pg.functionName();`

- Options properties
  - screenLg
  - screenMd
  - screenSm
  - viewportW
  - windowW
  
- Public methods
  - Toggle body class, when specific button is pressed
  - Toggle closest element class, when specific button is pressed
  - Redirect to URL on dropdown select
  - Close other accordions once one has been opened
  - Initialize Ekko lightbox
  - Smooth scroll to anchor target
  - Scroll back to top when button is clicked
  - Set all elements to same height within same class name
  - Desktop navbar dropdown smooth effect
  - Add Bootstrap table classes & Responsive table with table-responsive wrapper
  - Responsive transform tables on smaller devices - Header row becomes one column, other column represents data
  - Clear an input field with an 'X'

## Installation
Upload the files manually to your server and follow the on-screen instructions.

## Settings
- Navigate to WP admin area
- Go to `Settings -> Purgatorio`

Licenses & Credits
=
- WP_Query Arguments Code Snippets https://www.billerickson.net/code/wp_query-arguments/
- WP Theme Customization https://codex.wordpress.org/Class_Reference/WP_Customize_Manager/add_control
- Polylang Function Reference https://polylang.wordpress.com/documentation/documentation-for-developers/functions-reference/
- WPML Hooks Reference https://wpml.org/documentation/support/wpml-coding-api/wpml-hooks-reference/
