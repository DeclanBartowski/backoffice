<?php

namespace App\Services;

use App\Models\Restores;
use App\Models\Tariffs;
use App\Models\TariffsUserBlocks;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;


class UserService
{
    protected $sortField = 'users.updated_at';
    protected $sortOrder = 'DESC';
    private static $instance;
    private $tariff;

    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new static();
        }
        return self::$instance;
    }

    private function generatePassword(): string
    {
        return (\Faker\Factory::create())->password(10, 10);
    }

    public function register($params)
    {
        $password = $this->generatePassword();
        $user = new User();
        $user->email = $params['email'];
        $user->password = Hash::make($password);
        $result = $user->save();
        if ($result) {
            (new NotificationService($user))->sendRegister($password);
        }
        return $result;
    }

    public function restore($params)
    {
        $password = $this->generatePassword();
        $user = User::where('email', $params['email'])->first();
        $user->password = Hash::make($password);
        $result = $user->save();
        if ($result) {
            (new NotificationService($user))->sendRegister($password);
        }
        return $result;
    }

    /**
     * @throws ValidationException
     */
    public function login($request): \Illuminate\Http\JsonResponse
    {
        $status = Auth::attempt([
            'email' => $request['email'],
            'password' => $request['password'],
        ], isset($request['remember']));

        if ($status) {
            session()->regenerate();
            return response()->json(['link' => route('documents.index')]);
        } else {
            throw ValidationException::withMessages(['auth' => 'errors']);
        }
    }

    public function logout(): \Illuminate\Http\RedirectResponse
    {
        Auth::logout();
        return redirect()->route('auth');
    }

    public function sendLink($params)
    {
        $restore = new Restores();
        $restore->new_email = $params['email'];
        $restore->active = true;
        $restore->link = base64_encode(\auth()->user()->id . '_' . $params['email'] . time());
        $restore->user_id = \auth()->user()->id;
        $result = $restore->save();
        if ($result) {
            (new NotificationService($restore))->linkUser($restore->link);
        }
        return $result;
    }

    public function changeEmail(Restores $restores)
    {
        $result = true;
        if (!$restores->active) {
            $result = false;
        }
        $time = $restores->created_at->diffInHours(\Carbon\Carbon::now(), false);
        if ($time > 24) {
            $result = false;
        }
        if ($result) {
            $restores->active = false;
            $restores->save();
            $user = User::find($restores->user_id);
            $user->email = $restores->new_email;
            $user->save();
        }
        return $result;
    }

    public function getUsers()
    {
        //->orderBy($sortParams['field'], $sortParams['order'])
        $sortParams = $this->getSortParams();
        $result = User::join('tariffs_user_blocks', 'tariffs_user_blocks.user_id', '=', 'users.id')
            ->join('tariffs', 'tariffs.id', '=', 'tariffs_user_blocks.tariff')
            ->select('tariffs_user_blocks.tariff', 'tariffs.name', 'tariffs_user_blocks.active_to', 'users.created_at',
                'users.id', 'users.email', 'users.updated_at')->orderBy($sortParams['field'],
                $sortParams['order'])->paginate(10);

        return $result;
    }

    public function getSortParams(): array
    {
        return [
            'field' => session('users_sort_field', $this->sortField),
            'order' => session('users_sort_order', $this->sortOrder),
        ];
    }

    public function getTariff($user)
    {
        if (!$this->tariff) {
            $tariff = TariffsUserBlocks::where('user_id', $user->id)->where('active_to', '>',
                Carbon::now()->format('Y-m-d H:i:s'))->first();

            if ($tariff) {
                $this->tariff = Tariffs::find($tariff->tariff);
            } else {
                $this->tariff = Tariffs::where('default', true)->first();
            }
           /* $user->load('userTariff', 'userTariff.tariffElement');
                $this->tariff = $user->userTariff->tariffElement;
           */
        }
        return $this->tariff;
    }

    public function setSortParams($field, $order)
    {
        session([
            'users_sort_field' => $field,
            'users_sort_order' => $order,
        ]);
    }

}
