# localhost.run Setup Guide

## What is localhost.run?

localhost.run is a **free SSH-based tunneling service** that exposes your local server to the internet. It's an alternative to ngrok that:
- ✅ **Free** - No account needed
- ✅ **No installation** - Uses built-in SSH (already on macOS)
- ✅ **Works on same network** - No AP isolation issues
- ✅ **Simple** - One command to start

## Prerequisites

- SSH client (already installed on macOS)
- Laravel server running on port 8000
- Terminal access

---

## Step-by-Step Setup

### Step 1: Start Your Laravel Server

Open a terminal and start your Laravel server:

```bash
cd /Users/marnelleapat/Documents/online-event-registration
php artisan serve --host=127.0.0.1 --port=8000
```

Keep this terminal running.

### Step 2: Start localhost.run Tunnel

Open a **NEW terminal window** and run:

```bash
ssh -R 80:localhost:8000 localhost.run
```

**What this does:**
- `-R 80:localhost:8000` - Forwards port 80 on localhost.run to your local port 8000
- `localhost.run` - The SSH server that creates the tunnel

### Step 3: Get Your Public URL

After running the command, you'll see output like:

```
Connect to http://abc123.localhost.run or https://abc123.localhost.run
```

**Copy the HTTPS URL** (e.g., `https://abc123.localhost.run`)

### Step 4: Update Your .env File

Open your `.env` file and update:

```env
APP_URL=https://abc123.localhost.run
```

**Important:** Replace `abc123.localhost.run` with the actual URL you received.

### Step 5: Clear Laravel Cache

After updating `.env`, clear the cache:

```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```

### Step 6: Test Your Setup

1. Open the URL in your browser: `https://abc123.localurl.run`
2. Test from your phone on the same WiFi network
3. Test from mobile data (different network)

---

## Making It Easier: Create a Helper Script

### Option 1: Simple Alias (Recommended)

Add this to your `~/.zshrc` file:

```bash
# Add to ~/.zshrc
alias localhost-tunnel='ssh -R 80:localhost:8000 localhost.run'
```

Then reload:
```bash
source ~/.zshrc
```

Now you can just run:
```bash
localhost-tunnel
```

### Option 2: Create a Script File

Create a file `start-tunnel.sh` in your project root:

```bash
#!/bin/bash
echo "Starting localhost.run tunnel..."
echo "Make sure Laravel is running on port 8000!"
echo ""
ssh -R 80:localhost:8000 localhost.run
```

Make it executable:
```bash
chmod +x start-tunnel.sh
```

Run it:
```bash
./start-tunnel.sh
```

---

## Important Notes

### URL Changes Every Time

⚠️ **localhost.run gives you a NEW URL each time you connect**

To get a consistent URL, you can:
1. Use a subdomain (requires account): `ssh -R yourname:80:localhost:8000 ssh.localhost.run`
2. Or update `.env` each time you restart the tunnel

### Keep Both Terminals Running

You need **TWO terminals**:
1. **Terminal 1:** Laravel server (`php artisan serve`)
2. **Terminal 2:** localhost.run tunnel (`ssh -R 80:localhost:8000 localhost.run`)

### Stopping the Tunnel

Press `Ctrl+C` in the terminal running the SSH tunnel to stop it.

---

## Updating AppServiceProvider (Optional)

If you want to automatically detect localhost.run URLs, you can update `AppServiceProvider.php`:

```php
public function boot(): void
{
    // Force asset URLs to be absolute when using localhost.run or ngrok
    $appUrl = env('APP_URL');
    
    if ($appUrl && (str_contains($appUrl, 'localhost.run') || str_contains($appUrl, 'ngrok-free.app'))) {
        \Illuminate\Support\Facades\URL::forceRootUrl($appUrl);
        \Illuminate\Support\Facades\URL::forceScheme('https');
        
        if (!env('ASSET_URL')) {
            config(['app.asset_url' => $appUrl]);
        }
        
        // Force Laravel to use built assets instead of Vite dev server
        config(['vite.hmr.host' => null]);
        config(['vite.dev_server_url' => null]);
    }
}
```

---

## Troubleshooting

### Connection Refused

**Error:** `ssh: connect to host localhost.run port 22: Connection refused`

**Solution:** 
- Check your internet connection
- Try again (localhost.run servers may be temporarily busy)
- Wait a few seconds and retry

### Port Already in Use

**Error:** Port 8000 is already in use

**Solution:**
- Make sure only one Laravel server is running
- Or use a different port: `ssh -R 80:localhost:8001 localhost.run` (and start Laravel on port 8001)

### Can't Access from Phone

**Solution:**
- Make sure both devices are on the same network (or test from mobile data)
- Check that the HTTPS URL is correct
- Clear browser cache on your phone

### URL Not Working After Restart

**Solution:**
- localhost.run gives a new URL each time
- Update `.env` with the new URL
- Run `php artisan config:clear`

---

## Comparison: localhost.run vs ngrok

| Feature | localhost.run | ngrok |
|---------|--------------|-------|
| **Cost** | Free | Free tier available |
| **Installation** | None (uses SSH) | Requires installation |
| **Account** | Not required | Required for free tier |
| **Same Network** | ✅ Works | ❌ May have issues |
| **URL Stability** | Changes each time | Can be static (paid) |
| **Setup** | Simple | Simple |

---

## Quick Start Checklist

- [ ] Laravel server running on port 8000
- [ ] Run `ssh -R 80:localhost:8000 localhost.run`
- [ ] Copy the HTTPS URL from output
- [ ] Update `.env` with `APP_URL=https://your-url.localhost.run`
- [ ] Run `php artisan config:clear`
- [ ] Test in browser
- [ ] Test from phone (same WiFi)
- [ ] Test from phone (mobile data)

---

## Need Help?

If you encounter issues:
1. Check that Laravel is running: `curl http://localhost:8000`
2. Check SSH connection: `ssh -v -R 80:localhost:8000 localhost.run` (verbose mode)
3. Try a different port if 8000 is busy

