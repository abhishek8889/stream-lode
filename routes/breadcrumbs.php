 <?php
use App\Models\User;
use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;
 
// admin breadcrumbs

Breadcrumbs::for('admin-dashboard', function (BreadcrumbTrail $trail): void {
    $trail->push('Dashboard', route('admin-dashboard'));
});
Breadcrumbs::for('host-list', function (BreadcrumbTrail $trail): void {
    $trail->parent('admin-dashboard');
    $trail->push('host-list', route('host-list'));
});
Breadcrumbs::for('host-details', function (BreadcrumbTrail $trail): void {
    $trail->parent('host-list');
    $trail->push('host-details', route('host-details',['id' => 1]));
});
Breadcrumbs::for('guest-list', function (BreadcrumbTrail $trail): void {
    $trail->parent('admin-dashboard');
    $trail->push('Guest-list', route('guest-list'));
});

Breadcrumbs::for('membership-list', function (BreadcrumbTrail $trail): void {
    $trail->parent('admin-dashboard');
    $trail->push('membership-list', route('membership-list'));
});
Breadcrumbs::for('edit-membership', function (BreadcrumbTrail $trail): void {
    $trail->parent('membership-list');
    $trail->push('Edit-membership', route('edit-membership',['slug' => 1]));
});
Breadcrumbs::for('add-membership', function (BreadcrumbTrail $trail): void {
    $trail->parent('membership-list');
    $trail->push('Add-membership', route('add-membership'));
});
Breadcrumbs::for('features', function (BreadcrumbTrail $trail): void {
    $trail->parent('membership-list');
    $trail->push('Features', route('features'));
});
Breadcrumbs::for('discount', function (BreadcrumbTrail $trail): void {
    $trail->parent('admin-dashboard');
    $trail->push('Discount', route('discount-coupon-list'));
});
Breadcrumbs::for('discount-add', function (BreadcrumbTrail $trail): void {
    $trail->parent('discount');
    $trail->push('Genrate', route('generate-discount'));
});
Breadcrumbs::for('discount-Update', function (BreadcrumbTrail $trail): void {
    $trail->parent('discount');
    $trail->push('Update', route('update-discount',['id'=>1]));
});
Breadcrumbs::for('membership-payment-list', function (BreadcrumbTrail $trail): void {
    $trail->parent('admin-dashboard');
    $trail->push('Payments', route('membership-payment-list'));
});
Breadcrumbs::for('payment-details', function (BreadcrumbTrail $trail): void {
    $trail->parent('membership-payment-list');
    $trail->push('Details', route('membership-payment-details',['slug'=> 1]));
});
Breadcrumbs::for('meetings', function (BreadcrumbTrail $trail): void {
    $trail->parent('admin-dashboard');
    $trail->push('Appoinments', route('meetings'));
});
Breadcrumbs::for('Admin-setting', function (BreadcrumbTrail $trail): void {
    $trail->parent('admin-dashboard');
    $trail->push('General-Setting', route('admin-general-setting'));
});
Breadcrumbs::for('admin-changepassword', function (BreadcrumbTrail $trail): void {
    $trail->parent('admin-dashboard');
    $trail->push('Change-Password', route('changepassword'));
});

// end adminbreadcrumbs

// hostbreadcrumbs start
Breadcrumbs::for('host-dashboard', function (BreadcrumbTrail $trail): void {
    $trail->push('Dashboard', route('host-dashboard',['id'=> Auth::user()->unique_id]));
});
Breadcrumbs::for('host-general-settings', function (BreadcrumbTrail $trail): void {
    $trail->parent('host-dashboard');
    $trail->push('General-Setting', route('general-settings',['id'=> Auth::user()->unique_id]));
});
Breadcrumbs::for('tags', function (BreadcrumbTrail $trail): void {
    $trail->parent('host-dashboard');
    $trail->push('Tags', route('tags',['id'=> Auth::user()->unique_id]));
});
Breadcrumbs::for('change-password', function (BreadcrumbTrail $trail): void {
    $trail->parent('host-dashboard');
    $trail->push('Change-Password', route('change-password',['id'=> Auth::user()->unique_id]));
});
Breadcrumbs::for('membership-details', function (BreadcrumbTrail $trail): void {
    $trail->parent('host-dashboard');
    $trail->push('membership-details', route('membership-details',['id'=> Auth::user()->unique_id]));
});
Breadcrumbs::for('calender', function (BreadcrumbTrail $trail): void {
    $trail->parent('host-dashboard');
    $trail->push('Calender', route('host-calender',['id'=> Auth::user()->unique_id]));
});
Breadcrumbs::for('appoinments', function (BreadcrumbTrail $trail): void {
    $trail->parent('host-dashboard');
    $trail->push('Appoinments', route('appoinments',['id'=> Auth::user()->unique_id]));
});
// endhostbreadcrumbs
?>



