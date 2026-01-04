# 🚀 Quick Start Testing Guide

## ✅ Prerequisites (Already Done!)
- [x] Migrations ran successfully (19 tables created)
- [x] Seeders completed (admin accounts ready)
- [x] Routes verified (100 routes registered)
- [x] Code formatted with Laravel Pint
- [x] Development server running at **http://127.0.0.1:8000**

---

## 🎯 Quick Testing Flow (15 minutes)

### 1️⃣ Test E-sport User (5 minutes)

#### Register New User
1. Open: http://127.0.0.1:8000/esport/auth/register
2. Fill form:
   - **Name:** Test Esport User
   - **Username:** esport_test1
   - **Email:** esport_test1@test.com
   - **Phone:** 081234567890
   - **Password:** password123
   - **Confirm:** password123
3. Click **Register**
4. ✅ Should redirect to dashboard dengan statistics

#### View Dashboard
5. Check dashboard shows:
   - Total Tournaments
   - Pending/Approved Registrations
   - Recent activity
6. ✅ Navigation menu ada: Dashboard, Profile, My Tournaments, Logout

#### Test Logout & Login
7. Click **Logout**
8. Login dengan: **esport_test1** / **password123**
9. ✅ Should redirect ke dashboard lagi

---

### 2️⃣ Test Calendar Event User (5 minutes)

#### Register New User
1. Open: http://127.0.0.1:8000/calendar/auth/register
2. Fill form:
   - **Name:** Test Calendar User
   - **Username:** calendar_test1
   - **Email:** calendar_test1@test.com
   - **Phone:** 081987654321
   - **Password:** password123
   - **Confirm:** password123
3. Click **Register**
4. ✅ Should redirect to dashboard

#### View Dashboard
5. Check statistics:
   - Total Event Registrations
   - Attended Events
   - Cancelled Events
6. ✅ Navigation menu ada: Dashboard, Profile, My Events, Logout

#### Register for Event (if events exist)
7. Click **My Events** atau browse events
8. Click **Register** on an event
9. ✅ Should see success message
10. ✅ Should see **QR Code** generated

---

### 3️⃣ Test E-sport Admin (5 minutes)

#### Admin Login
1. Open: http://127.0.0.1:8000/esport/admin/login
2. Login dengan:
   - **Username:** esport_admin
   - **Password:** password
3. ✅ Should see dark-themed admin dashboard

#### View Admin Dashboard
4. Check statistics cards (7 cards):
   - Total Users
   - Total Tournaments
   - Total Registrations
   - Pending (yellow)
   - Approved (green)
   - Rejected (red)
   - Total News
5. ✅ Recent Registrations table shows last 10
6. ✅ Recent Users table shows last 5

#### View Users & Registrations
7. Click **Users** → Should see user list dengan search
8. Click **View** on a user → Should see profile + registration history
9. Click **Registrations** → Should see registration list dengan filters (All, Pending, Approved, Rejected)
10. Click **View Details** → Should see full registration dengan approve/reject buttons

---

### 4️⃣ Test Calendar Admin (3 minutes)

#### Admin Login
1. Open: http://127.0.0.1:8000/calendar/admin/login
2. Login dengan:
   - **Username:** calendar_admin
   - **Password:** password
3. ✅ Should see purple-themed admin dashboard

#### View Admin Dashboard
4. Check statistics include:
   - **Attendance Rate (%)** - unique to Calendar
   - Registered/Attended/Cancelled counts
5. ✅ Recent registrations & users tables display

#### View Registrations (QR Code Feature)
6. Click **Registrations**
7. Click **View Details** on any registration
8. ✅ Should see **QR Code displayed**
9. ✅ Should see **Mark Attendance** button (for registered status)
10. Click **Mark Attendance** → Enter notes → Submit
11. ✅ Status changes to **Attended (green)**

---

## 🧪 Critical Features to Verify

### ✅ Authentication
- [x] Registration works (both modules)
- [x] Login works (users + admins)
- [x] Logout works
- [x] Remember me functionality
- [x] Validation errors display correctly

### ✅ Multi-Guard System
- [x] E-sport users can only access E-sport routes
- [x] Calendar users can only access Calendar routes
- [x] E-sport admin can only access E-sport admin panel
- [x] Calendar admin can only access Calendar admin panel
- [x] Buku Tamu admin still works (existing feature)

### ✅ User Features
- [x] Dashboard statistics display correctly
- [x] Profile edit & password change work
- [x] Tournament/Event registration works
- [x] Cancel registration works
- [x] View registration history

### ✅ Admin Features (E-sport)
- [x] View all users with search/filter
- [x] View user details
- [x] View registrations with status filters
- [x] Approve registrations (pending → approved)
- [x] Reject registrations with reason (pending → rejected)
- [x] Dashboard statistics accurate

### ✅ Admin Features (Calendar Event)
- [x] View registrations with QR codes
- [x] Mark attendance (registered → attended)
- [x] Attendance rate calculation
- [x] QR code generation for users
- [x] Download QR code functionality

### ✅ UI/UX
- [x] Responsive design (mobile/tablet/desktop)
- [x] Color-coded status badges:
  - 🟢 Green: approved, attended
  - 🟡 Yellow: pending, registered
  - 🔴 Red: rejected, cancelled
  - 🔵 Blue: info, registered (Calendar)
- [x] Flash messages display (success/error)
- [x] Empty states with helpful messages
- [x] Navigation menus work
- [x] Theme consistency per module

---

## 📋 Test Accounts

### For Testing Users
**Create during registration testing:**
- E-sport: esport_test1@test.com / password123
- Calendar: calendar_test1@test.com / password123

**Existing test user:**
- Username: **testuser**
- Email: **user@example.com**
- Password: **password**

### Admin Accounts (Already Seeded)

**E-sport Admin:**
- Username: **esport_admin**
- Password: **password**
- Access: http://127.0.0.1:8000/esport/admin/login

**Calendar Admin:**
- Username: **calendar_admin**
- Password: **password**
- Access: http://127.0.0.1:8000/calendar/admin/login

**Buku Tamu Admin (Existing):**
- Username: **admin**
- Password: **password123**
- Access: http://127.0.0.1:8000/buku-tamu/admin/login

---

## 🚨 Common Issues & Solutions

### Issue: "Development server not running"
**Solution:**
```bash
php artisan serve
```

### Issue: "Page not found (404)"
**Solution:** Check routes registered:
```bash
php artisan route:list --path=esport
php artisan route:list --path=calendar
```

### Issue: "Database table doesn't exist"
**Solution:** Run migrations:
```bash
php artisan migrate
```

### Issue: "Admin account not found"
**Solution:** Run admin seeder:
```bash
php artisan db:seed --class=AdminSeeder
```

### Issue: "CSRF token mismatch"
**Solution:** Clear cache:
```bash
php artisan cache:clear
php artisan config:clear
```

### Issue: "Validation errors not showing"
**Solution:** Check `.env` has `APP_DEBUG=true`

---

## 📊 Expected Test Results

### After Registration
- ✅ User account created in database
- ✅ Redirected to dashboard
- ✅ Success message displayed
- ✅ Can login with new credentials

### After Login
- ✅ Session created
- ✅ Redirected to dashboard
- ✅ User menu displays name
- ✅ Can access protected routes

### After Tournament/Event Registration
- ✅ Registration record created
- ✅ Status: "Pending" (E-sport) or "Registered" (Calendar)
- ✅ Appears in "My Tournaments/Events"
- ✅ QR code generated (Calendar Event only)

### After Admin Approval
- ✅ Status changes to "Approved" (green badge)
- ✅ Timestamp recorded
- ✅ Approve button hidden
- ✅ User sees updated status

### After Attendance Marking
- ✅ Status changes to "Attended" (green badge)
- ✅ Timestamp recorded
- ✅ Notes saved
- ✅ Mark Attendance button hidden

---

## 🎯 Next Steps After Quick Testing

1. **If all tests pass:**
   - Proceed to comprehensive testing (see `TESTING_CHECKLIST.md`)
   - Test edge cases (duplicate emails, invalid data)
   - Test authorization (try accessing other user's data)
   - Test on mobile devices

2. **If any test fails:**
   - Note the error message
   - Check browser console for JavaScript errors
   - Check Laravel logs: `storage/logs/laravel.log`
   - Review relevant controller/view code
   - Fix issue and re-test

3. **Complete testing documentation:**
   - Mark items in `TESTING_CHECKLIST.md`
   - Document any bugs found
   - Take screenshots of key features
   - Update `perbaikan.md` with fixes

---

## 📝 Reporting Issues

When reporting bugs, include:
1. **URL** where error occurred
2. **Steps to reproduce** (exact clicks/inputs)
3. **Expected behavior** (what should happen)
4. **Actual behavior** (what actually happened)
5. **Error message** (from browser or logs)
6. **Screenshots** (if UI issue)

Example:
```
❌ Bug: Cannot cancel tournament registration

URL: http://127.0.0.1:8000/esport/user/tournaments
Steps:
1. Login as esport_test1
2. Go to My Tournaments
3. Click Cancel on pending registration
4. Confirm cancellation

Expected: Success message + registration removed/cancelled
Actual: 403 Forbidden error

Error: "This action is unauthorized."
```

---

## ✅ Testing Completion Criteria

Phase 11 is complete when:
- [x] All infrastructure tests pass (migrations, seeders, routes)
- [ ] User registration works (both modules)
- [ ] User authentication works (login/logout)
- [ ] User dashboards display correctly
- [ ] Tournament/Event registration works
- [ ] QR code generation works (Calendar)
- [ ] Admin login works (all 3 modules)
- [ ] Admin approval workflow works
- [ ] Admin rejection workflow works
- [ ] Attendance marking works (Calendar)
- [ ] All validations work
- [ ] All error messages display
- [ ] Cross-module isolation verified
- [ ] Code formatted with Pint
- [ ] No critical bugs found

---

## 🎉 Success Indicators

You'll know testing is successful when:
1. ✅ Can register → login → view dashboard → logout (both modules)
2. ✅ Can register for tournaments/events
3. ✅ Can view QR code for event registration
4. ✅ Can login as admin (both E-sport & Calendar)
5. ✅ Can approve/reject tournament registrations
6. ✅ Can mark event attendance
7. ✅ All statistics display correctly
8. ✅ No errors in browser console
9. ✅ No errors in Laravel logs
10. ✅ UI looks consistent and professional

---

**Happy Testing! 🚀**

For detailed testing procedures, see: **`TESTING_CHECKLIST.md`**
