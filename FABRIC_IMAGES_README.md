# Fabric Images Integration

## Overview
This document describes the integration of fabric images into the GUF XTORE website.

## Image Files
The following fabric images have been integrated into the website:

1. **fabric1.webp** - Premium Silk Fabric (2.5MB)
2. **fabric.jpeg** - Cotton Linen Blend (7.6KB)
3. **fabric2.jpeg** - Designer Print Fabric (8.7KB)
4. **fabric3.jpeg** - Luxury Velvet (27KB)
5. **fabric4.jpeg** - Lightweight Chiffon (4.9KB)
6. **fabric5.jpeg** - Sturdy Denim (12KB)
7. **images.jpeg** - Elegant Satin (9.2KB)
8. **The-Various-Types-of-Fabrics-and-How-to-Clean-Them.webp** - Organic Cotton Collection (303KB)

## Product Cards Features

### Responsive Design
- **Desktop**: 4 columns on large screens (xl+)
- **Tablet**: 3 columns on medium screens (lg)
- **Mobile**: 2 columns on small screens (md)
- **Small Mobile**: 1 column on extra small screens (sm)

### Image Aspect Ratio
- **Maintained 4:3 aspect ratio** for consistent card heights
- **object-fit: cover** ensures images fill containers properly
- **Responsive adjustments** for different screen sizes

### Enhanced Features
- **Product Badges**: Premium, Popular, New, Luxury, Durable, Eco-friendly, Collection
- **Star Ratings**: 5-star rating system with review counts
- **Hover Effects**: Image zoom and action buttons on hover
- **Quick Actions**: Eye (quick view) and Heart (wishlist) buttons
- **Material Information**: Display fabric composition and care instructions
- **Price Display**: Clear pricing with "per 5 yards" unit

### Badge Colors
- **Premium**: Gold gradient
- **Popular**: Red gradient
- **New**: Green gradient
- **Luxury**: Purple gradient
- **Durable**: Blue gradient
- **Eco-friendly**: Green gradient
- **Collection**: Purple gradient

## File Structure
```
/home/king/Documents/jesse/
├── fabrics/
│   ├── fabric1.webp
│   ├── fabric.jpeg
│   ├── fabric2.jpeg
│   ├── fabric3.jpeg
│   ├── fabric4.jpeg
│   ├── fabric5.jpeg
│   ├── images.jpeg
│   └── The-Various-Types-of-Fabrics-and-How-to-Clean-Them.webp
├── index.html
├── shop.html
├── cart.html
├── contact.html
├── about.html
├── style.css
├── main.js
├── shop.js
├── cart.js
├── contact.js
├── about.js
├── utils.js
└── preloader.js
```

## Usage
The fabric images are automatically loaded in:
1. **Homepage**: Featured products section
2. **Shop Page**: All products with filtering and sorting
3. **Product Details**: Quick view modals
4. **Cart**: Product thumbnails

## Performance Optimization
- **Lazy Loading**: Images load only when needed
- **Responsive Images**: Appropriate sizes for different devices
- **Optimized File Sizes**: Compressed images for faster loading
- **Aspect Ratio Maintenance**: Consistent card layouts

## Browser Support
- Modern browsers with CSS Grid support
- Fallback layouts for older browsers
- Progressive enhancement approach
