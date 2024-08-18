<?php

namespace App\Controllers;

use App\Models\TournamentModel;

class Tournament extends BaseController
{
    function index()
    {
        //echo 'Hello Codeigniter 4';
        if (!session()->get('logged_in')) {
            return redirect()->to('/auth');
        }
        $crudModel = new TournamentModel();

        $data['user_data'] = $crudModel->orderBy('id', 'DESC')->paginate(10);

        $data['pagination_link'] = $crudModel->pager;

        return view('tournament/index', $data);
    }

    function view()
    {
        //echo 'Hello Codeigniter 4';

        $crudModel = new TournamentModel();

        $data['user_data'] = $crudModel->orderBy('id', 'DESC')->paginate(10);

        $data['pagination_link'] = $crudModel->pager;

        return view('tournament/view', $data);
    }

    public function create()
    {
        return view('tournament/create');
    }

    public function createSave()
    {
        $model = new TournamentModel();

        // Validate input
        $validation = \Config\Services::validation();
        $validation->setRules([
            'name' => 'required',
            'modality' => 'required',
            'price' => 'required',
            'date' => 'required',
        ]);

        if ($validation->withRequest($this->request)->run()) {
            // Upload image

            $data = [
                'name' => $this->request->getPost('name'),
                'modality' => $this->request->getPost('modality'),
                'price' => $this->request->getPost('price'),
                'date' => $this->request->getPost('date'),
            ];
            // Save data
            $model->insert($data);

            return redirect()->to('/tournament')->with('success', 'Adicionado com sucesso.');
        } else {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }
    }

    public function edit($id)
    {
        $model = new TournamentModel();
        $data['post'] = $model->find($id);
        return view('tournament/update', $data);
    }

    public function update($id)
    {
        $model = new TournamentModel();

        // Validation
        $rules = [
            'modality' => 'required',
            'price' => 'required',
            'date' => 'required',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Update data
        $data = [
            'modality' => $this->request->getPost('modality'),
            'price' => $this->request->getPost('price'),
            'date' => $this->request->getPost('date'),
        ];

        $model->update($id, $data);

        return redirect()->to('/tournament')->with('success', 'Atualizado com sucesso.');
    }

    public function delete($id)
    {
        $model = new TournamentModel();
        $model->delete($id);
        return redirect()->to('/tournament')->with('success', 'Apagado com sucesso.');
    }
}
