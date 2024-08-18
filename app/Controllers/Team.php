<?php

namespace App\Controllers;

use App\Models\TeamModel;

class Team extends BaseController
{
    function index()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/auth');
        }
        $teamModel = new TeamModel();

        $data['user_data'] = $teamModel->orderBy('id', 'DESC')->paginate(10);

        return view('team/index', $data);
    }

    function view()
    {
        $teamModel = new TeamModel();

        $data['user_data'] = $teamModel->orderBy('id', 'DESC')->paginate(10);

        return view('team/view', $data);
    }

    public function createSave()
    {
        $model = new TeamModel();

        $validation = \Config\Services::validation();

        $validation->setRules([
            'name' => 'required',
            'country' => 'required',
            'date' => 'required'
        ]);

        if ($validation->withRequest($this->request)->run()) {

            $data = [
                'name' => $this->request->getPost('name'),
                'country' => $this->request->getPost('country'),
                'date' => $this->request->getPost('date')
            ];

            $model->insert($data);

            return redirect()->to('/team')->with('success', 'Adicionado com sucesso.');
        } else {

            print_r($validation->getErrors());

            exit;

            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }
    }

    public function update($id)
    {
        $model = new TeamModel();

        $rules = [
            'name' => 'required',
            'country' => 'required',
            'date' => 'required'
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'name' => $this->request->getPost('name'),
            'country' => $this->request->getPost('country'),
            'date' => $this->request->getPost('date')
        ];

        $model->update($id, $data);

        return redirect()->to('/team')->with('success', 'Atualizado com sucesso.');
    }

    public function delete($id)
    {

        try {
            $model = new TeamModel();
            $model->delete($id);
            return redirect()->to('/team')->with('success', 'Apagado com sucesso.');
        } catch (\CodeIgniter\Database\Exceptions\DatabaseException $e) {
            return redirect()->to('/team')->with('error', 'Sorry, its not possible to delete this team as its currently being used in a transfer.');
        } catch (\Exception $e) {
            return redirect()->to('/team')->with('error', 'Sorry, an error occurred while deleting the team: ' . $e->getMessage());
        }
    }
}
