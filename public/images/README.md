# Images Directory

Place static images here that you want to reference directly in your application.

## Usage Examples:

1. **Default Event Poster**: `public/images/default-event-poster.jpg`
   - Access via: `{{ asset('images/default-event-poster.jpg') }}`

2. **Logo Images**: `public/images/logo.png`
   - Access via: `{{ asset('images/logo.png') }}`

3. **Icon Images**: `public/images/icons/icon-name.svg`
   - Access via: `{{ asset('images/icons/icon-name.svg') }}`

## Note:
- Files in this directory are publicly accessible
- Use this for static assets that don't change
- For user-uploaded content, use `storage/app/public/` instead
