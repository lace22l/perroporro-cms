# Weird blog cms
``` 
docker run -d \
-p 80:80 \
--name my-awesome-blog \
-v /home/user/persistant-data:/var/www/var \
ghcr.io/lace22l/perroporro-cms:main
```

* Your persistant data directory needs permissions rw php-fpm permissions
---

## Image management
1. Navigate to Images to upload images. 
2. After uploading click on Copy Link to get the link to the image in your clipboard.
3. Use this url in either the Artwork category, Blog in *Markdown* format, or in your info cards as a regular html image
## Cards personalization.

The content of a card is rendered as is, be careful with this, you can write html javascript and css.
The css uses bootstrap, so you can take advantage of Column Row system



Amb 💙 des dels països catalans

<img width="220" height="220" alt="image" src="https://lace22.dog/assets/snoopa.gif" />

<img width="1200" height="900" alt="image" src="https://github.com/user-attachments/assets/b1c43443-6b42-4eca-be40-023e6c218d7a" />
