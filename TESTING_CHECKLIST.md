# Testing Checklist - Multi-Module Authentication System

## ✅ Phase 11: Testing & Verification

### 1. Infrastructure Setup ✅ COMPLETED

- [x] Run migrations: `php artisan migrate:status`
  - ✅ 19 migrations ran successfully
  - ✅ All tables created (users, admins, tournaments, events, registrations)
  
- [x] Run seeders
  - ✅ AdminSeeder: All admin accounts ready (Buku Tamu, E-sport, Calendar)
  - ✅ UserSeeder: Test users exist (testuser@example.com)
  
- [x] Verify routes: `php artisan route:list`
  - ✅ E-sport: 56 routes registered
  - ✅ Calendar: 44 routes registered
  - ✅ Total: 100 routes verified
  
- [x] Start development server: `php artisan serve`
  - ✅ Server running at http://127.0.0.1:8000
  
- [x] Format code: `vendor\bin\pint`
  - ✅ 188 files formatted, 18 style issues fixed

---

### 2. E-sport User Module Testing

#### 2.1 User Registration (/esport/auth/register)
- [ ] Access registration page
- [ ] Test successful registration with valid data:
  - Name: "Test User E-sport"
  - Username: "esport_user1"
  - Email: "esport_user1@test.com"
  - Phone: "08123456789"
  - Password: "password123"
  - Password Confirmation: "password123"
- [ ] Verify redirect to dashboard after registration
- [ ] Verify success flash message displayed
- [ ] Check database for new user record

#### 2.2 Validation Testing - Registration
- [ ] Test duplicate username error
- [ ] Test duplicate email error
- [ ] Test invalid email format
- [ ] Test password minimum length (< 8 characters)
- [ ] Test password confirmation mismatch
- [ ] Test required field validation (leave fields empty)
- [ ] Verify error messages display correctly

#### 2.3 User Login (/esport/auth/login)
- [ ] Test login with username
- [ ] Test login with email
- [ ] Test "Remember Me" checkbox functionality
- [ ] Verify redirect to dashboard
- [ ] Test invalid credentials error message
- [ ] Test account not found error

#### 2.4 User Dashboard (/esport/user/dashboard)
- [ ] Verify dashboard loads after login
- [ ] Check statistics display:
  - [ ] Total Tournaments count
  - [ ] Pending Registrations count
  - [ ] Approved Registrations count
- [ ] Check "My Recent Tournaments" section displays
- [ ] Verify navigation menu works
- [ ] Test "Profile" link
- [ ] Test "My Tournaments" link
- [ ] Test "Logout" button

#### 2.5 User Profile Management (/esport/user/profile/edit)
- [ ] Load profile edit page
- [ ] Update profile information (name, email, phone)
- [ ] Verify success message on update
- [ ] Test profile photo upload (if enabled)
- [ ] Change password successfully
- [ ] Test current password validation
- [ ] Test new password confirmation
- [ ] Verify password changed (logout and login with new password)

#### 2.6 Tournament Browsing (/esport/tournaments)
- [ ] View tournaments list
- [ ] Check pagination works
- [ ] View tournament details
- [ ] Verify registration button visible
- [ ] Check tournament information displays correctly

#### 2.7 Tournament Registration (/esport/user/tournaments)
- [ ] Navigate to "My Tournaments" page
- [ ] Click "Register" on available tournament
- [ ] Fill registration form:
  - [ ] Team Name (if team tournament)
  - [ ] In-game ID
  - [ ] Additional notes
- [ ] Submit registration
- [ ] Verify success message
- [ ] Check registration appears in "My Tournaments" with "Pending" status

#### 2.8 Cancel Tournament Registration
- [ ] Find pending registration in list
- [ ] Click "Cancel" button
- [ ] Confirm cancellation
- [ ] Verify success message
- [ ] Check registration status changed or removed
- [ ] Test cannot cancel approved registration (button disabled)

---

### 3. Calendar Event User Module Testing

#### 3.1 User Registration (/calendar/auth/register)
- [ ] Access registration page
- [ ] Test successful registration with valid data:
  - Name: "Test User Calendar"
  - Username: "calendar_user1"
  - Email: "calendar_user1@test.com"
  - Phone: "08198765432"
  - Password: "password123"
  - Password Confirmation: "password123"
- [ ] Verify redirect to dashboard
- [ ] Verify success message displayed
- [ ] Check database for new user record

#### 3.2 Validation Testing - Registration
- [ ] Test duplicate username error
- [ ] Test duplicate email error
- [ ] Test invalid email format
- [ ] Test password rules
- [ ] Test required fields
- [ ] Verify all error messages clear and helpful

#### 3.3 User Login (/calendar/auth/login)
- [ ] Test login with username
- [ ] Test login with email
- [ ] Test "Remember Me" functionality
- [ ] Verify redirect to dashboard
- [ ] Test invalid credentials handling

#### 3.4 User Dashboard (/calendar/user/dashboard)
- [ ] Verify dashboard loads
- [ ] Check statistics:
  - [ ] Total Event Registrations
  - [ ] Attended Events
  - [ ] Cancelled Events
- [ ] Check "My Recent Events" displays
- [ ] Test navigation links
- [ ] Test logout functionality

#### 3.5 User Profile Management (/calendar/user/profile/edit)
- [ ] Load profile page
- [ ] Update profile information
- [ ] Verify update success
- [ ] Change password
- [ ] Test password validations
- [ ] Verify changes saved

#### 3.6 Event Browsing (/calendar/events)
- [ ] View events list
- [ ] Check calendar view
- [ ] View event details
- [ ] Verify registration button visible
- [ ] Check event date/time displays correctly

#### 3.7 Event Registration (/calendar/user/events)
- [ ] Navigate to "My Events" page
- [ ] Register for an event
- [ ] Verify success message
- [ ] Check registration appears with "Registered" status
- [ ] **Verify QR code generated and displayed**

#### 3.8 QR Code Display (/calendar/user/events/{id})
- [ ] Click on registered event
- [ ] Verify QR code image displays
- [ ] Check event details shown
- [ ] Test "Download QR Code" button
- [ ] Verify QR code contains correct data:
  - Event Registration ID
  - User ID
  - Event ID
  - Unique attendance code

#### 3.9 Cancel Event Registration
- [ ] Find registered event
- [ ] Click "Cancel Registration"
- [ ] Confirm cancellation
- [ ] Verify success message
- [ ] Check status changed to "Cancelled"
- [ ] Test cannot cancel attended event

---

### 4. Buku Tamu Admin Module Testing (Existing - Regression Test)

#### 4.1 Admin Login (/buku-tamu/admin/login)
- [ ] Access admin login page
- [ ] Test login with existing credentials
- [ ] Verify redirect to admin dashboard
- [ ] Check admin navigation available
- [ ] Test logout

#### 4.2 Admin Dashboard
- [ ] Verify dashboard loads
- [ ] Check visitor statistics display
- [ ] Test navigation to visitor list
- [ ] Test navigation to expressions
- [ ] Verify all existing features still work

---

### 5. E-sport Admin Module Testing

#### 5.1 Admin Login (/esport/admin/login)
- [ ] Access admin login page (verify dark theme)
- [ ] Test login with credentials:
  - Username: "esport_admin"
  - Password: "password"
- [ ] Verify redirect to E-sport admin dashboard
- [ ] Check admin guard working (esport_admin)
- [ ] Test logout functionality

#### 5.2 Admin Dashboard (/esport/admin/dashboard)
- [ ] Verify dashboard loads
- [ ] Check statistics cards:
  - [ ] Total Users
  - [ ] Total Tournaments
  - [ ] Total Registrations
  - [ ] Pending Registrations (yellow badge)
  - [ ] Approved Registrations (green badge)
  - [ ] Rejected Registrations (red badge)
  - [ ] Total News
- [ ] Check "Recent Registrations" table (last 10)
- [ ] Check "Recent Users" table (last 5)
- [ ] Check "Active Tournaments" section with registration counts
- [ ] Verify all links work

#### 5.3 User Management (/esport/admin/users)
- [ ] Access users list
- [ ] Test search by name
- [ ] Test search by email
- [ ] Test filter by registration status
- [ ] Check pagination works
- [ ] Click "View" on a user
- [ ] Verify user detail page loads

#### 5.4 User Detail View (/esport/admin/users/{id})
- [ ] Verify user profile displays:
  - Name, Username, Email, Phone
  - Join date
- [ ] Check "Registration History" table displays
- [ ] Verify tournament registrations listed with status
- [ ] Check team info displays (if applicable)
- [ ] Test "Back to List" button

#### 5.5 Registration Management (/esport/admin/registrations)
- [ ] Access registrations list
- [ ] Test filter tabs:
  - [ ] All Registrations
  - [ ] Pending (yellow badge)
  - [ ] Approved (green badge)
  - [ ] Rejected (red badge)
- [ ] Test search by username
- [ ] Test search by tournament name
- [ ] Check registration cards display correctly
- [ ] Click "View Details"

#### 5.6 Registration Detail & Approval (/esport/admin/registrations/{id})
- [ ] Load registration detail page
- [ ] Verify all information displays:
  - [ ] User information (name, email, phone)
  - [ ] Tournament information
  - [ ] Team Name (if applicable)
  - [ ] In-game ID
  - [ ] Registration date
  - [ ] Current status badge
- [ ] Test "Approve" button (for pending):
  - [ ] Click approve
  - [ ] Verify confirmation prompt
  - [ ] Confirm approval
  - [ ] Check success message
  - [ ] Verify status changed to "Approved" (green badge)
  - [ ] Verify approval timestamp displayed
  - [ ] Check approve button hidden after approval

#### 5.7 Registration Rejection (/esport/admin/registrations/{id})
- [ ] Find a pending registration
- [ ] Click "Reject" button
- [ ] Verify rejection reason form displays
- [ ] Enter rejection reason: "Team roster incomplete"
- [ ] Submit rejection
- [ ] Check success message
- [ ] Verify status changed to "Rejected" (red badge)
- [ ] Verify rejection reason displayed
- [ ] Verify rejection timestamp displayed
- [ ] Check reject button hidden after rejection

#### 5.8 Authorization Testing - E-sport Admin
- [ ] Logout from E-sport admin
- [ ] Try accessing E-sport admin routes directly (should redirect to login)
- [ ] Try accessing Calendar admin routes (should be denied/redirect)
- [ ] Try accessing with regular user account (should be denied)
- [ ] Verify admin can only manage E-sport module

---

### 6. Calendar Event Admin Module Testing

#### 6.1 Admin Login (/calendar/admin/login)
- [ ] Access admin login page (verify purple theme)
- [ ] Test login with credentials:
  - Username: "calendar_admin"
  - Password: "password"
- [ ] Verify redirect to Calendar admin dashboard
- [ ] Check admin guard working (calendar_admin)
- [ ] Test logout

#### 6.2 Admin Dashboard (/calendar/admin/dashboard)
- [ ] Verify dashboard loads
- [ ] Check statistics cards:
  - [ ] Total Users
  - [ ] Total Events
  - [ ] Total Registrations
  - [ ] **Attendance Rate (%)** - unique to Calendar
  - [ ] Registered (blue badge)
  - [ ] Attended (green badge)
  - [ ] Cancelled (red badge)
- [ ] Check "Recent Registrations" table
- [ ] Check "Recent Users" table
- [ ] Check "Upcoming Events" with registration counts
- [ ] Verify attendance rate calculation correct

#### 6.3 User Management (/calendar/admin/users)
- [ ] Access users list
- [ ] Test search functionality
- [ ] Test filter by status
- [ ] Check event registration counts per user
- [ ] View user detail page

#### 6.4 User Detail View (/calendar/admin/users/{id})
- [ ] Verify user profile displays
- [ ] Check "Event Registration History" table
- [ ] Verify attendance status displayed
- [ ] Check QR code information (if any)
- [ ] Test back button

#### 6.5 Registration Management (/calendar/admin/registrations)
- [ ] Access registrations list
- [ ] Test filter tabs:
  - [ ] All Registrations
  - [ ] Registered (blue badge)
  - [ ] Attended (green badge)
  - [ ] Cancelled (red badge)
- [ ] Test search by username
- [ ] Test search by event name
- [ ] Check attendance rate displayed
- [ ] Click "View Details"

#### 6.6 Registration Detail & Attendance (/calendar/admin/registrations/{id})
- [ ] Load registration detail page
- [ ] Verify all information displays:
  - [ ] User information
  - [ ] Event information
  - [ ] **QR Code display** (unique to Calendar)
  - [ ] Registration date
  - [ ] Current status badge
  - [ ] Attendance code
- [ ] Test "Mark Attendance" button (for registered status):
  - [ ] Click mark attendance
  - [ ] Verify attendance form displays
  - [ ] Enter attendance notes: "Attended via QR scan"
  - [ ] Submit attendance
  - [ ] Check success message
  - [ ] Verify status changed to "Attended" (green badge)
  - [ ] Verify attended timestamp displayed
  - [ ] Verify notes displayed
  - [ ] Check mark attendance button hidden after marking

#### 6.7 QR Code Scanning Simulation
- [ ] Get user's QR code from their event registration page
- [ ] Navigate to registration management as admin
- [ ] Find the registration
- [ ] Verify QR code matches user's QR code
- [ ] Mark attendance with note: "Scanned QR code at event entrance"
- [ ] Verify attendance marked successfully

#### 6.8 Authorization Testing - Calendar Admin
- [ ] Logout from Calendar admin
- [ ] Try accessing Calendar admin routes directly (should redirect)
- [ ] Try accessing E-sport admin routes (should be denied)
- [ ] Try accessing with regular user account (should be denied)
- [ ] Verify admin can only manage Calendar module

---

### 7. Cross-Module Testing

#### 7.1 Multi-Guard Authentication
- [ ] Login as E-sport user
- [ ] Verify can only access E-sport user routes
- [ ] Try accessing Calendar user routes (should prompt re-login)
- [ ] Try accessing admin routes (should be denied)
- [ ] Logout and login as Calendar user
- [ ] Verify same isolation

#### 7.2 Admin Guard Isolation
- [ ] Login as E-sport admin
- [ ] Verify cannot access Calendar admin pages
- [ ] Verify cannot access Buku Tamu admin pages
- [ ] Login as Calendar admin
- [ ] Verify cannot access E-sport admin pages
- [ ] Login as Buku Tamu admin
- [ ] Verify can only access Buku Tamu features

#### 7.3 User Data Isolation
- [ ] Register as E-sport user
- [ ] Register tournaments
- [ ] Login as different E-sport user
- [ ] Verify cannot see/cancel other user's registrations
- [ ] Repeat for Calendar Event users
- [ ] Verify policy enforcement working

---

### 8. Edge Cases & Error Handling

#### 8.1 Database Constraints
- [ ] Test duplicate registration (register for same tournament twice)
- [ ] Test registration for non-existent tournament
- [ ] Test registration for past event
- [ ] Test registration for full event (if capacity implemented)

#### 8.2 Status Transitions
- [ ] Test approve → reject (should fail or warn)
- [ ] Test reject → approve (should fail or require reset)
- [ ] Test cancel → approve (should fail)
- [ ] Test attended → cancel (should fail)

#### 8.3 Authorization Edge Cases
- [ ] Try editing other user's profile (should fail)
- [ ] Try canceling other user's registration (should fail)
- [ ] Try accessing admin routes without login (should redirect)
- [ ] Try SQL injection in search fields (should be escaped)
- [ ] Try XSS in text fields (should be escaped)

#### 8.4 File Handling
- [ ] Upload profile photo with invalid format (if enabled)
- [ ] Upload oversized profile photo (if enabled)
- [ ] Test QR code generation failure handling
- [ ] Test missing QR code display

---

### 9. UI/UX Testing

#### 9.1 Responsive Design
- [ ] Test on mobile viewport (375px)
- [ ] Test on tablet viewport (768px)
- [ ] Test on desktop viewport (1920px)
- [ ] Verify all forms usable on mobile
- [ ] Check navigation menu collapses properly

#### 9.2 Visual Consistency
- [ ] Verify E-sport user pages use blue/dark theme
- [ ] Verify Calendar user pages use blue/green theme
- [ ] Verify E-sport admin uses dark theme
- [ ] Verify Calendar admin uses purple theme
- [ ] Check all status badges consistent colors:
  - Green: approved/attended
  - Yellow: pending/registered
  - Red: rejected/cancelled
  - Blue: info/registered (Calendar)

#### 9.3 Flash Messages
- [ ] Test success messages display (green)
- [ ] Test error messages display (red)
- [ ] Test warning messages display (yellow)
- [ ] Verify messages auto-dismiss or have close button
- [ ] Check messages positioned correctly

#### 9.4 Loading States
- [ ] Check form submission shows loading indicator
- [ ] Test pagination loading
- [ ] Test search result loading
- [ ] Verify no double-submission possible

#### 9.5 Empty States
- [ ] View "My Tournaments" with no registrations
- [ ] View "My Events" with no registrations
- [ ] Search with no results
- [ ] Filter with no matching records
- [ ] Verify helpful empty state messages displayed

---

### 10. Performance & Security

#### 10.1 Performance
- [ ] Check page load times (< 2s)
- [ ] Test pagination efficiency (10 items per page)
- [ ] Verify images optimized
- [ ] Check database query count (N+1 queries?)
- [ ] Test with 100+ registrations in list

#### 10.2 Security
- [ ] Verify all forms have CSRF tokens
- [ ] Test CSRF token validation
- [ ] Check password fields are type="password"
- [ ] Verify passwords hashed in database
- [ ] Test SQL injection prevention
- [ ] Test XSS prevention
- [ ] Check authorization on all protected routes
- [ ] Verify admin routes require authentication

---

### 11. Documentation & Code Quality

#### 11.1 Code Quality
- [x] Run Laravel Pint: `vendor\bin\pint`
  - ✅ 188 files formatted
  - ✅ 18 style issues fixed
- [ ] Check for TODO/FIXME comments
- [ ] Verify all controller methods have docblocks
- [ ] Check for unused imports
- [ ] Review code for best practices

#### 11.2 Documentation
- [ ] Verify README.md updated
- [ ] Check CALENDAR_EVENT_IMPLEMENTATION.md complete
- [ ] Verify tambah-fitur.md reflects current status
- [ ] Ensure perbaikan.md updated
- [ ] Review ACTION_PLAN_IMPROVEMENTS.md

---

## Testing Summary

### Phase 11 Progress: ~50% Complete

#### ✅ Completed
- Infrastructure setup (migrations, seeders, routes, server)
- Code formatting (Laravel Pint)
- Documentation checklist created

#### ⏳ In Progress
- Manual testing procedures

#### ❌ Pending
- User registration flows (E-sport & Calendar)
- Admin approval/rejection workflows
- QR code generation & scanning
- Cross-module authentication testing
- Edge case & error handling
- UI/UX responsive testing
- Performance & security testing

---

## How to Use This Checklist

1. **Start Development Server** (if not running):
   ```bash
   php artisan serve
   ```

2. **Open Browser**: http://127.0.0.1:8000

3. **Follow Sections in Order**: Start with Section 2 (E-sport User), then 3 (Calendar User), then admins

4. **Mark Items as Complete**: Use `[x]` when tested successfully

5. **Document Issues**: If test fails, note issue below checkbox with details

6. **Take Screenshots**: Capture screens of key features (QR codes, dashboards, approvals)

7. **Report Critical Bugs**: Stop testing and fix critical issues before proceeding

---

## Test Accounts

### Users (for manual testing)
- **Existing Test User**:
  - Username: `testuser`
  - Email: `user@example.com`
  - Password: `password`

- **Create new users during testing** using registration forms

### Admin Accounts
- **Buku Tamu Admin** (existing):
  - Username: `admin`
  - Password: `password123`

- **E-sport Admin**:
  - Username: `esport_admin`
  - Password: `password`

- **Calendar Admin**:
  - Username: `calendar_admin`
  - Password: `password`

---

## Notes
- All tests should be performed on a clean database with seeded data
- Test on Chrome/Firefox/Edge for cross-browser compatibility
- Document any issues found in separate bug report
- Priority: Critical bugs (authentication, data loss) > High (major features) > Low (UI polish)
