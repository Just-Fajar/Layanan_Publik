import puppeteer from 'puppeteer-core';
import path from 'path';
import fs from 'fs';
import { fileURLToPath } from 'url';

const __dirname = path.dirname(fileURLToPath(import.meta.url));
const chromePath = 'C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe';
const baseUrl = process.env.APP_URL || 'http://127.0.0.1:8000';

const publicScreenshots = [
    { name: '01-portal/01-portal-beranda.png', url: '/' },
    { name: '02-buku-tamu/01-buku-tamu-form-publik.png', url: '/buku-tamu' },
    { name: '02-buku-tamu/02-admin-login.png', url: '/admin/login' },
    { name: '03-calendar/01-calendar-katalog-publik.png', url: '/calendar' },
    { name: '03-calendar/02-calendar-jadwal-bulanan.png', url: '/calendar/view/month' },
    { name: '03-calendar/03-calendar-detail-event.png', url: '/calendar/1' },
    { name: '03-calendar/04-calendar-auth-user.png', url: '/calendar/login' },
    { name: '04-esport/01-esport-beranda.png', url: '/esport' },
    { name: '04-esport/02-esport-daftar-turnamen.png', url: '/esport/tournaments' },
    { name: '04-esport/03-esport-detail-turnamen.png', url: '/esport/tournaments/1' },
    { name: '04-esport/04-esport-kabar-berita.png', url: '/esport/news' },
    { name: '04-esport/05-esport-detail-berita.png', url: '/esport/news/1' },
    { name: '04-esport/06-esport-auth-user.png', url: '/esport/login' },
    { name: '05-errors/01-error-404.png', url: '/dev/errors/404' },
    { name: '05-errors/02-error-403.png', url: '/dev/errors/403' },
    { name: '05-errors/03-error-500.png', url: '/dev/errors/500' },
    { name: '05-errors/04-error-503.png', url: '/dev/errors/503' },
];

const adminScreenshots = [
    { name: '02-buku-tamu/03-buku-tamu-admin-dashboard.png', url: '/admin/buku-tamu/dashboard' },
    { name: '02-buku-tamu/04-buku-tamu-admin-calendar.png', url: '/admin/buku-tamu/calendar' },
    { name: '02-buku-tamu/05-buku-tamu-admin-visitors.png', url: '/admin/buku-tamu/visitors' },
    { name: '03-calendar/07-calendar-admin-management.png', url: '/calendar/admin/events' },
    { name: '04-esport/09-esport-admin-tournaments.png', url: '/esport/admin/tournaments' },
];

const userScreenshots = [
    { name: '03-calendar/05-calendar-user-dashboard.png', url: '/calendar/user/dashboard' },
    { name: '03-calendar/06-calendar-user-ticket-qr.png', url: '/calendar/user/events' },
    { name: '04-esport/07-esport-user-dashboard.png', url: '/esport/user/dashboard' },
    { name: '04-esport/08-esport-user-tournaments.png', url: '/esport/user/tournaments' },
];

async function capture(page, item) {
    const fullUrl = `${baseUrl}${item.url}`;
    const targetPath = path.join(__dirname, '../docs/screenshots', item.name);
    fs.mkdirSync(path.dirname(targetPath), { recursive: true });

    await page.goto(fullUrl, { waitUntil: 'load', timeout: 30000 });
    await new Promise(r => setTimeout(r, 1000));
    await page.screenshot({ path: targetPath, fullPage: true });
    console.log(`[SAVED] ${item.name}`);
}

async function run() {
    console.log('Starting screenshot capture...');
    const browser = await puppeteer.launch({
        executablePath: chromePath,
        headless: 'new',
        args: ['--no-sandbox', '--disable-setuid-sandbox', '--window-size=1440,900']
    });

    const page = await browser.newPage();
    await page.setViewport({ width: 1440, height: 900 });

    // 1. Public & Errors
    for (const item of publicScreenshots) {
        await capture(page, item);
    }

    // 2. Admin
    await page.goto(`${baseUrl}/admin/login`, { waitUntil: 'load' });
    await page.type('#username', 'superadmin');
    await page.type('#password', 'SuperAdmin123!');
    await page.click('.login-btn');
    await new Promise(r => setTimeout(r, 3000));

    for (const item of adminScreenshots) {
        await capture(page, item);
    }

    // 3. User
    const userContext = await browser.createBrowserContext();
    const userPage = await userContext.newPage();
    await userPage.setViewport({ width: 1440, height: 900 });

    await userPage.goto(`${baseUrl}/login`, { waitUntil: 'load' });
    await userPage.type('input[name="email"]', 'user@example.com');
    await userPage.type('input[name="password"]', 'password');
    await Promise.all([
        userPage.waitForNavigation({ waitUntil: 'load' }),
        userPage.click('button[type="submit"]')
    ]);

    for (const item of userScreenshots) {
        await capture(userPage, item);
    }

    await browser.close();
    console.log('All screenshots completed successfully!');
}

run().catch(err => {
    console.error(err);
    process.exit(1);
});
