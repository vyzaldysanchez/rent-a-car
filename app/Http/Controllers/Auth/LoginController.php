<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models \{
    User, Employee
};

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    protected function authenticated(Request $request, User $user) : JsonResponse
    {
        $user->employeeId = Employee::where('user_id', '=', $user->id)->pluck('id')->first();
        return $this->success($user);
    }

    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        return $this->noContent();
    }
}
