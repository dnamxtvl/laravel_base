<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use App\Data\Models\User;
//use Illuminate\Support\Facades\Hash;
//use Illuminate\Support\Facades\DB;
//use Illuminate\Support\Facades\Log;
//use Illuminate\Support\Facades\Http;
//use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UserController extends Controller
{
    public function __construct(
        private readonly User $user
    ){}

    public function index(): View
    {
        $listUsers = $this->user->query()->orderByDesc('created_at')->paginate(20);

        return view('users.index', compact('listUsers'));
    }

    public function create(): View
    {
//        $listRoles = $this->role->all();

        return view('users.create');
    }

    public function store(Request $request)
    {
//        $validated = $request->validate([
//            'name' => 'required|max:255',
//            'email' => 'required|max:255',
//            'password' => 'required|max:255',
//            'role' => 'required'
//        ]);
//
//        $data = $request->except(["_token"]);
//
//        $data['password'] = Hash::make($data['password']);
//
//        DB::beginTransaction();
//        try {
//            $newUser = new User();
//            $newUser->password = $data['password'];
//            $newUser->name = $data['name'];
//            $newUser->email = $data['email'];
//            $newUser->save();
//            $newUser->assignRole($request->role);
//            DB::commit();
//
//            return redirect()->route('users.index')->with('success', 'Created user success!');
//        } catch (\Exception $e) {
//            DB::rollBack();
//            return back()->with('error', $e->getMessage());
//        }
    }

    public function edit($id)
    {
//        $user = $this->user->findOrFail($id);
//        $listRoles = $this->role->all();
//
//        return view('users.edit', compact('user', 'listRoles'));
    }

    public function test($id)
    {
        //compariison chunk vs chunkById
//        $chunk = $this->user->orderBy('name')->chunk(4, function ($users) {
//            foreach ($users as $user) {
//                dump($user->id . ' - ' . $user->name . '<br>');
//            }
//            dump($users);
//        });
//
//        dump('chunk By id');
//
//        $chunk = $this->user->orderBy('name')->chunkById(4, function ($users) {
//            foreach ($users as $user) {
//                dump($user->id . ' - ' . $user->name . '<br>');
//            }
////            dump($users);
//        });
//        return $this->serve(RespondWithJsonErrorJob::class, [
//            'message' => 'Loi',
//            'code' => 6363,
//            'status' => ResponseAlias::HTTP_BAD_GATEWAY,
//        ]);
//        throw new NotFoundHttpException('Không tồn tại user');
//        $user = $this->user->findOrFail(92579)->name;
////        dd(2255);
//         $testCallApi = Http::get('http://panda.local/test', []);
//         dd($testCallApi->json());
//        Log::alert('Lấy dữ liệu thành công dòng ' . __LINE__);
//        return response()->json([
//            'success' => true,
//            'code' => 200,
//            'message' => 'Lấy data thành công!'
//        ]);
    }
}
