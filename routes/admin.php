



<?php
use App\Http\Controllers\Admin\AddRefferalController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminLoginController;
use App\Http\Controllers\Admin\CreditDebitController;
use App\Http\Controllers\Admin\DebitProfitController;
use App\Http\Controllers\Admin\DepositController;
use App\Http\Controllers\Admin\MailController;
use App\Http\Controllers\Admin\ManageDepositController;
use App\Http\Controllers\Admin\ManageEscrowController;
use App\Http\Controllers\Admin\ManageLoanController;
use App\Http\Controllers\Admin\ManagePaymentController;
use App\Http\Controllers\Admin\ManageUserController;
use App\Http\Controllers\Admin\ProfitController;
use App\Http\Controllers\Admin\SendEmailController;
use App\Http\Controllers\Admin\WalletController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;




     Route::middleware(['web'])->prefix('admin')->name('admin.')->group(function () {

    Route::middleware('guest:admin')->group(function () {
        Route::get('/login', [AdminLoginController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [AdminLoginController::class, 'login'])->name('login.post');
    });

    Route::middleware('auth:admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
        Route::post('/logout', [AdminLoginController::class, 'logout'])->name('logout');
    });

// manger user details from admin
Route::get('/users', 'App\Http\Controllers\UserManagementController@viewUser')->name('users');
Route::get('/profile/{id}/', 'App\Http\Controllers\UserManagementController@userProfile')->name('profile');
Route::match(['get', 'post'], '/approve-deposit/{id}/', 'App\Http\Controllers\UserManagementController@ApproveDeposit')->name('approve.deposit');
Route::match(['get', 'post'], '/decline-deposit/{id}/', 'App\Http\Controllers\UserManagementController@DeclineDeposit')->name('decline.deposit');

Route::match(['get', 'post'], '/approve-withdrawal/{id}/', 'App\Http\Controllers\UserManagementController@ApproveWithdrawal')->name('approve.withdrawal');
Route::match(['get', 'post'], '/decline-withdrawal/{id}/', 'App\Http\Controllers\UserManagementController@DeclineWithdrawal')->name('decline.withdrawal');
Route::get('/add-profit/{id}/', 'App\Http\Controllers\UserManagementController@getUserProfit');
Route::post('/debit-profit', 'App\Http\Controllers\UserManagementController@debitUserProfit')->name('debit.profit');
Route::get('/debit-profit/{id}/', 'App\Http\Controllers\UserManagementController@getDebitProfit');
Route::post('/add-profit', 'App\Http\Controllers\UserManagementController@addUserProfit')->name('add.profit');
Route::get('/add-deposit/{id}/', 'App\Http\Controllers\UserManagementController@getUserDeposit');
Route::post('/add-deposit', 'App\Http\Controllers\UserManagementController@addUserDeposit')->name('add.deposit');
Route::get('/add-referral/{id}/', 'App\Http\Controllers\UserManagementController@getUserReferral');
Route::post('/add-referral', 'App\Http\Controllers\UserManagementController@addUserReferral')->name('add.referral');
Route::get('/total-deposits', 'App\Http\Controllers\UserManagementController@usersDeposit');
Route::get('/total-withdrawals', 'App\Http\Controllers\UserManagementController@usersWithdrawals');
Route::get('/total-profits', 'App\Http\Controllers\UserManagementController@usersProfit');
Route::get('/update-wallet', 'App\Http\Controllers\UserManagementController@updateWallet')->name('wallet');
Route::post('/choose-wallet', 'App\Http\Controllers\UserManagementController@chooseWallet')->name('choose-wallet');
Route::post('/update-trc', 'App\Http\Controllers\UserManagementController@updateTrc')->name('update-trc');
Route::post('/update-btc', 'App\Http\Controllers\UserManagementController@updateBtc')->name('update-btc');
Route::post('/update-eth', 'App\Http\Controllers\UserManagementController@updateEth')->name('update-eth');
Route::post('/update-bank', 'App\Http\Controllers\UserManagementController@updateBank')->name('update-bank');
Route::get('/all-transactions', 'App\Http\Controllers\UserManagementController@allTransactions')->name('user.transactions');
Route::get('/send-mail', 'App\Http\Controllers\UserManagementController@sendTestMail');
Route::get('/send-mail/{id}/', 'App\Http\Controllers\UserManagementController@sendMail');
Route::post('/send-user-email', 'App\Http\Controllers\UserManagementController@sendUserEmail');
Route::match(['get', 'post'], '/delete/{id}', 'App\Http\Controllers\UserManagementController@deleteUser')->name('delete');
Route::get('send-user-mail/{id}', 'App\Http\Controllers\UserManagementController@sendUserMail');
Route::get('update_wallet', 'App\Http\Controllers\UserManagementController@updateWallet')->name('update.wallet');
Route::post('admin_update_wallet', 'App\Http\Controllers\UserManagementController@saveWallet')->name('admin.save.wallet');
Route::post('/update-signal', 'App\Http\Controllers\UserManagementController@updateSignal')->name('update-signal');
Route::get('/add-traders', 'App\Http\Controllers\UserManagementController@addTrader')->name('add-traders');
Route::get('/edit-trader/{id}/', 'App\Http\Controllers\UserManagementController@editTrader');
Route::match(['get', 'post'], 'update-trader/{id}', 'App\Http\Controllers\UserManagementController@updateTrader')->name('update.trader');
Route::post('save-trader', 'App\Http\Controllers\UserManagementController@saveTrader')->name('save.trader');
Route::get('/delete-trader/{id}', 'App\Http\Controllers\UserManagementController@deleteTrader');
Route::match(['get', 'post'], '/accept-kyc/{id}/', 'App\Http\Controllers\UserManagementController@acceptKyc')->name('accept.kyc');
Route::match(['get', 'post'], '/decline-kyc/{id}/', 'App\Http\Controllers\UserManagementController@rejectKyc')->name('decline.kyc');
Route::get('/accept-bot/{id}/', 'App\Http\Controllers\UserManagementController@acceptBot');
Route::get('/decline-bot/{id}/', 'App\Http\Controllers\UserManagementController@rejectBot');
Route::match(['get', 'post'], 'send-mail', 'App\Http\Controllers\UserManagementController@sendMail')->name('send.mail');
Route::post('update-signal-strength/{id}/', 'App\Http\Controllers\UserManagementController@updateSignalStrength')->name('signal.strength');
Route::post('update-notification/{id}/', 'App\Http\Controllers\UserManagementController@updateNotification')->name('update.notification');
Route::post('update-profit-limit-status/{id}/', 'App\Http\Controllers\UserManagementController@updateProfitLimitStatus')->name('update.profit.limit.status');
Route::post('update-escrow/{id}/', 'App\Http\Controllers\UserManagementController@updateEscrow')->name('update.escrow');
Route::post('update-withdrawal-code/{id}/', 'App\Http\Controllers\UserManagementController@updatewithdrawalcode')->name('update.withdrawal_code');
Route::post('update-withdrawal-percentage/{id}/', 'App\Http\Controllers\UserManagementController@updatewithdrawalpercentage')->name('update.withdrawal_percentage');
Route::post('update-withdrawal-amount/{id}/', 'App\Http\Controllers\UserManagementController@updatewithdrawalamount')->name('update.withdrawal_amount');

Route::post('update-withdrawal-tax-amount/{id}/', 'App\Http\Controllers\UserManagementController@updatewithdrawalTaxamount')->name('update.withdrawal_tax_amount');

Route::get('/clear-account/{id}', 'App\Http\Controllers\UserManagementController@clearAccount')->name('clear.account');
Route::get('/manage-withdrawal','App\Http\Controllers\UserManagementController@manageWithdrawal')->name('manage-withdrawal');
Route::get('/manage-deposit','App\Http\Controllers\UserManagementController@manageDeposit')->name('manage-deposit');
Route::get('/{user}/suspension', 'App\Http\Controllers\UserManagementController@userSuspension')->name('user.suspension');





//wallet update

    Route::post('/choose-wallet', [WalletController::class, 'chooseWallet'])->name('choose.wallet');

    Route::get('/deposits', [ManageDepositController::class, 'UsersDepositHistory'])->name('deposits');

    Route::get('/manage-payment', [ManagePaymentController::class, 'ManagePayment'])->name('manage.payment');

    Route::get('/send-email', [SendEmailController::class, 'index'])->name('send.email');
    Route::post('/send-email', [SendEmailController::class, 'send'])->name('send.email.post');

    Route::get('/transactions', 'App\Http\Controllers\UserManagementController@allTransactions')->name('transactions');

    Route::post('/update-tradefee/{id}', [ManageUserController::class, 'updateTradefee'])->name('update.tradefee');
    Route::post('/users/send-mail', 'App\Http\Controllers\UserManagementController@sendUserEmail')->name('users.send-mail');
    Route::post('/update-password', 'App\Http\Controllers\UserManagementController@updateAdminPassword')->name('update.password');

});

