<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class RecordController extends BaseController
{
    public function index()
    {
        $data['records'] = $this->ApplicationModel->getAllRecords();
        return view('pages/records/index', $data);
    }

    public function create()
    {
        return view('pages/records/create');
    }

    public function store()
    {
        // 3.1: Server-side validation
        $rules = [
            'title'       => 'required|min_length[3]',
            'description' => 'required',
            'category'    => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('notif_error', 'Please check your inputs.');
        }

        $data = [
            'title'       => $this->request->getVar('title'),
            'description' => $this->request->getVar('description'),
            'category'    => $this->request->getVar('category'),
            'status'      => 'Active'
        ];

        $this->ApplicationModel->insertRecord($data);
        return redirect()->to(base_url('records'))->with('notif_success', 'Record added successfully!');
    }
}