# Pelican Panel Plugins

A collection of plugins for [Pelican Panel](https://github.com/pelican-dev/panel).

## Available Plugins

| Plugin | Description |
|--------|-------------|
| [server-documentation](./server-documentation) | Attach markdown documentation to servers with versioning and role-based access |

## Installation

### Option 1: Download from Releases (Recommended)
1. Go to the [Releases](https://github.com/gavinmcfall/pelican-plugins/releases) page
2. Download the `server-documentation.zip` from the latest release
3. In Pelican Panel: **Admin → Plugins → Upload** and select the zip file

### Option 2: Manual Installation
1. Download/clone this repository
2. Copy the `server-documentation` folder to your panel's `plugins/` directory:
   ```bash
   cp -r server-documentation /var/www/pelican/plugins/
   ```
3. In Pelican Panel: **Admin → Plugins** and click **Install** next to the plugin

## ☕ Support

If you find these plugins helpful, consider supporting my work:

[![Ko-fi](https://img.shields.io/badge/Ko--fi-Support%20Me-FF5E5B?style=for-the-badge&logo=ko-fi&logoColor=white)](https://ko-fi.com/gavinmcfall)

---

## License

See individual plugin directories for license information.
