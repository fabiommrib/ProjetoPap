<?php

namespace App\Controllers;

use App\Models\NewsModel;

class News extends BaseController
{
    function index()
    {
        //echo 'Hello Codeigniter 4';
        if (!session()->get('logged_in')) {
            return redirect()->to('/auth');
        }
        $crudModel = new NewsModel();

        $data['user_data'] = $crudModel->orderBy('id', 'DESC')->paginate(10);

        $data['pagination_link'] = $crudModel->pager;

        return view('news/index', $data);
    }

    function view()
    {
        //echo 'Hello Codeigniter 4';

        $crudModel = new NewsModel();

        $data['user_data'] = $crudModel->orderBy('date', 'DESC')->paginate(10);

        $data['pagination_link'] = $crudModel->pager;

        return view('news/view', $data);
    }

    public function create()
    {
        return view('news/create');
    }

    public function createSave()
    {
        $model = new NewsModel();

        // Validate input
        $validation = \Config\Services::validation();
        $validation->setRules([
            'title' => 'required',
            'description' => 'required',
            'date' => 'required',
        ]);

        if ($validation->withRequest($this->request)->run()) {
            // Upload image

            $data = [
                'title' => $this->request->getPost('title'),
                'description' => $this->request->getPost('description'),
                'date' => $this->request->getPost('date'),
            ];
            // Save data
            $model->insert($data);

            return redirect()->to('/news')->with('success', 'Adicionado com sucesso.');
        } else {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }
    }

    public function edit($id)
    {
        $model = new NewsModel();
        $data['post'] = $model->find($id);
        return view('news/update', $data);
    }

    public function update($id)
    {
        $model = new NewsModel();

        // Validation
        $rules = [
            'title' => 'required',
            'description' => 'required',
            'date' => 'required',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Update data
        $data = [
            'title' => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'date' => $this->request->getPost('date'),
        ];

        $model->update($id, $data);

        return redirect()->to('/news')->with('success', 'Atualizado com sucesso.');
    }

    public function delete($id)
    {
        $model = new NewsModel();
        $model->delete($id);
        return redirect()->to('/news')->with('success', 'Apagado com sucesso.');
    }
}
