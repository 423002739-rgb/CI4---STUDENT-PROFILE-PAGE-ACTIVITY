<?php

namespace App\Controllers;

use App\Models\StudentModel;

class Student extends BaseController
{
    public function index()
    {
        $model = new StudentModel();
        $data = array_merge($this->data, [
            'students' => $model->findAll()
        ]);
        return view('pages/student_view', $data);
    }

    public function store()
    {
        $model = new StudentModel();
        $data = [
            'name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'course' => $this->request->getPost('course'),
        ];
        $model->insert($data);
        return redirect()->to('/students');
    }

 public function delete($id)
{
    // 1. I-bypass ang lahat ng Models, Filters, at BaseController logic
    $db = \Config\Database::connect();
    
    // 2. Patakbuhin ang Raw SQL Query na walang kinalaman sa framework models
    $sql = "DELETE FROM students WHERE id = :id:";
    
    // 3. I-execute gamit ang bind para iwas-SQL Injection
    $db->query($sql, ['id' => $id]);
    
    // 4. I-redirect nang malinis
    return redirect()->to('/students')->with('notif_success', 'Record deleted successfully!');
}
    // 3.3: Show Edit Form
    public function edit($id)
    {
        $model = new StudentModel();
        $data = array_merge($this->data, [
            'student' => $model->find($id) // Kunin ang data ng specific student
        ]);
        return view('pages/student_edit', $data);
    }

    // 3.3: Update Logic
    public function update($id)
    {
        $model = new StudentModel();
        $data = [
            'name'   => $this->request->getPost('name'),
            'email'  => $this->request->getPost('email'),
            'course' => $this->request->getPost('course'),
        ];
        
        $model->update($id, $data); // I-save ang binagong data
        return redirect()->to('/students')->with('notif_success', 'Updated successfully!');
    }
}
