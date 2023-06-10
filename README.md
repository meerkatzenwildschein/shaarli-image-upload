# Shaarli Image Upload Plugin

This plugin for Shaarli allows users to upload an image file when sharing a link. The image is stored in the `data/images` directory, and a link to the image is automatically prefilled in the text content dialog.

## Features

- Image upload when sharing a link: When you share a link, you can select and upload an image file from your computer. The image file is then stored on the server.
- Automatic link to the image: After the image is uploaded, a link to the image is automatically added to the text content of the shared link. This makes it easy to include a relevant image with each link you share.
- Easy integration: The plugin is designed to integrate seamlessly with Shaarli's existing features and plugins. It does not require any changes to your Shaarli installation, and can be enabled or disabled from the plugin administration page.

## Installation

To install the plugin, first create a new directory within the plugins path of your Shaarli installation named image_upload. Next, copy all the plugin files into this new directory. Finally, navigate to the plugin administration page in Shaarli and enable the Image Upload plugin.

### Docker Installation

If you're running Shaarli in a Docker container, you can use a Docker volume to install the plugin:

1. First, download the plugin and save it to a directory on your host machine, e.g., `/var/lib/volumes/image_upload`.

2. Then, when starting your Shaarli Docker container, mount the directory to the correct path inside the container `/var/www/shaarli/plugins/image_upload`.


## Usage

When you share a link, you will see an option to upload an image. Click the "Choose File" button, select an image file, and then click "Save". The image will be uploaded to the shaarli data folder, and a link to the image will be added to the text content of the shared link.

