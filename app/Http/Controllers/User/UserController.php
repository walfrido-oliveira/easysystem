<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use \App\Role\UserRole;
use App\User;
use Hash;
Use App\User\UserHasClient;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('check_user_role:' . UserRole::ROLE_ADMIN);
    }

    public function index()
    {
        $users = User::where('active',1)->paginate(10);

        $hrefs = array();

        $actions = array();

        $columns = array();

        $sort = array();

        foreach ($users as $key => $value)
        {
            $hrefs[$value->id] =  route('users.edit',$value->id);
            $actions[$value->id] = route('users.destroy',$value->id);
        }

        $columns = array(
            array(
                "label" => "Nome",
                "name" => "name",
                "sort" => true,
                "uniqueId" => true,
                "initial_sort_order" => "desc",
                "filter" =>
                    array(
                        "type" => "simple"
                    )
            ),
            array(
                "label" => "Email",
                "name" => "email",
                "sort" =>  true,
                "filter" =>
                    array(
                        "type" => "simple"
                    )
            ),
            array(
                "label" => "Acões",
                "name" => "actions",
                "sort" => false,
            )
        );

        $sort = array(
            array(
            "name" => "id",
            "order" => "desc"
            )
        );

        return view('adm.acess.user.index',
        compact('users','hrefs','actions','columns','sort'))
        ->with('i', (request()->input('page', 1) - 1) * 5);

    }

     /**
     * Get clients list
     *
     * @return JSON
     */
    public function getUsers(Request $request)
    {

        $json = json_decode($request->queryParams);

        if (isset($json->sort))
        {
            $sort = $json->sort;
        }

        if (isset($json->filters))
        {
            $filters = $json->filters;
        }

        if (isset($json->per_page))
        {
            $per_page = $json->per_page;
        }
        else
        {
            $per_page = 10;
        }

        $filtersArray = array();

        if (!empty($filters))
        {
            foreach ($filters as $key => $value)
            {
                $filtersArray[] = [$filters[$key]->name,'like','%'.$filters[$key]->text.'%'];
            }
        }

        if (!empty($sort) && !empty($filters))
        {
            $query = User::where($filtersArray)->orderBy($sort[0]->name, $sort[0]->order)->paginate($per_page);
        }
        else if (!empty($sort))
        {
            $query = User::where('active',1)->orderBy($sort[0]->name, $sort[0]->order)->paginate($per_page);
        }
        else
        {
            $query = User::where($filtersArray)->paginate($per_page);
        }

        return ['data' => $query];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('adm.acess.user.create');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Client\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $clients = $users = UserHasClient::where('user_id',$user->id)->get();

        return view('adm.acess.user.edit',compact('user','clients'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate($this->rules(true), $this->mesagens());

        $data = $request->all();

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'type' => $data['type'],
            'active' => $data['active'],
        ]);

        if ($data['type'] === 'adm')
        {
            $user->addRole(UserRole::ROLE_ADMIN)->save();
        } else if($data['type'] == 'user') {
            $user->addRole(UserRole::ROLE_USER)->save();
        }

        $data = $data['clients'];

        foreach ($data as $key => $value) {
            UserHasClient::create([
                'user_id' => $user->id,
                'client_id' => $value['client_id'],
            ]
            );
        }

        $user->sendEmailVerificationNotification();

        return redirect()->route('users.index')
            ->with('success','Usuário adicionado com sucesso');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Client\User  $client
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {

        $request->validate($this->rules(false), $this->mesagens());

        $data = $request->all();

        $user->update([
            'type' => $data['type'],
            'active' => $data['active'],
        ]);

        $user->setRoles([])->save();

        if ($data['type'] === 'adm')
        {
            $user->addRole(UserRole::ROLE_ADMIN)->save();
        } else if($data['type'] == 'user') {
            $user->addRole(UserRole::ROLE_USER)->save();
        }

        if (isset($data['clients']))
        {
            $data = $data['clients'];

            foreach ($data as $key => $value) {
                $client = UserHasClient::where('user_id',$user->id)->where('client_id',$value['client_id'])->get()->count();
                if ($client == 0) {
                    UserHasClient::create([
                        'user_id' => $user->id,
                        'client_id' => $value['client_id'],
                    ]
                    );
                } else {

                }
            }
        }

        return redirect()->route('users.index')
                        ->with('success','Usuário atualizado com sucesso');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Client\User  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy(user $user)
    {
        $user->delete();

        return redirect()->route('users.index')
                        ->with('success','Usuário deletado com sucesso');
    }

    /**
     * Set rules validation
     *
     * @return array
     */
    private function rules($is_new)
    {
        if ($is_new == true)
        {
            return array(
                'name' => 'required|max:255|unique:users',
                'email' => 'required|max:255|unique:users',
                'password' => 'required|min:8|confirmed',
                'type' => 'required',
            );
        } else {
            return array(
                'type' => 'required',
            );
        }
    }

    /**
     * Set mesagens validation
     *
     * @return array
     */
    private function mesagens()
    {
        return array(
            'name.required' => 'O campo nome é obrigatório',
            'name.max' => 'O nome não está em um formato correto',
            'name.unique' => 'Nome já cadastrado',
            'email.required' => 'O campo email é obrigatório',
            'email.max' => 'O email não está em um formato correto',
            'email.unique' => 'Email já cadastrado',
            'password.required' => 'O campo senha é obrigatório',
            'password.min' => 'A senha deve ter no mínimo 8 caracteres',
            'password.confirmed' => 'As senhas devem ser iguais',
            'type.required' => 'O campo tipo é obrigatório',
        );
    }
}
