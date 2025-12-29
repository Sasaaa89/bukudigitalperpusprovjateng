<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\FormFieldModel;

class FormBuilderController extends BaseController
{
    protected $formFieldModel;

    public function __construct()
    {
        $this->formFieldModel = new FormFieldModel();
    }

    public function index()
    {
        $formType = $this->request->getGet('type') ?? 'feedback';
        
        $data = [
            'title' => 'Form Builder',
            'currentType' => $formType,
            'fields' => $this->formFieldModel->getFormFields($formType)
        ];

        return view('admin/form_builder/index', $data);
    }

    public function create()
    {
        if ($this->request->getMethod() === 'POST') {
            $fieldOptions = $this->request->getPost('field_options');
            
            // Convert options to JSON if it's an array
            if (is_array($fieldOptions)) {
                $fieldOptions = json_encode(array_filter($fieldOptions));
            }

            $data = [
                'form_type' => $this->request->getPost('form_type'),
                'field_name' => $this->request->getPost('field_name'),
                'field_label' => $this->request->getPost('field_label'),
                'field_type' => $this->request->getPost('field_type'),
                'is_required' => $this->request->getPost('is_required') ? 1 : 0,
                'field_options' => $fieldOptions,
                'sort_order' => $this->request->getPost('sort_order') ?? 0,
                'is_active' => 1
            ];

            if ($this->formFieldModel->insert($data)) {
                return redirect()->to('/admin/form-builder?type=' . $data['form_type'])->with('success', 'Field berhasil ditambahkan!');
            } else {
                return redirect()->back()->with('error', 'Gagal menambahkan field!');
            }
        }

        $data = ['title' => 'Tambah Field Form'];
        return view('admin/form_builder/create', $data);
    }

    public function edit($id)
    {
        $field = $this->formFieldModel->find($id);
        
        if (!$field) {
            return redirect()->to('/admin/form-builder')->with('error', 'Field tidak ditemukan!');
        }

        if ($this->request->getMethod() === 'POST') {
            $fieldOptions = $this->request->getPost('field_options');
            
            // Convert options to JSON if it's an array
            if (is_array($fieldOptions)) {
                $fieldOptions = json_encode(array_filter($fieldOptions));
            }

            $data = [
                'field_name' => $this->request->getPost('field_name'),
                'field_label' => $this->request->getPost('field_label'),
                'field_type' => $this->request->getPost('field_type'),
                'is_required' => $this->request->getPost('is_required') ? 1 : 0,
                'field_options' => $fieldOptions,
                'sort_order' => $this->request->getPost('sort_order'),
                'is_active' => $this->request->getPost('is_active') ? 1 : 0
            ];

            if ($this->formFieldModel->update($id, $data)) {
                return redirect()->to('/admin/form-builder?type=' . $field['form_type'])->with('success', 'Field berhasil diupdate!');
            } else {
                return redirect()->back()->with('error', 'Gagal mengupdate field!');
            }
        }

        $data = [
            'title' => 'Edit Field Form',
            'field' => $field
        ];
        
        return view('admin/form_builder/edit', $data);
    }

    public function delete($id)
    {
        $field = $this->formFieldModel->find($id);
        
        if ($this->formFieldModel->delete($id)) {
            return redirect()->to('/admin/form-builder?type=' . $field['form_type'])->with('success', 'Field berhasil dihapus!');
        } else {
            return redirect()->back()->with('error', 'Gagal menghapus field!');
        }
    }

    public function updateOrder()
    {
        $orders = $this->request->getJSON(true);
        
        foreach ($orders as $order) {
            $this->formFieldModel->updateSortOrder($order['id'], $order['sort_order']);
        }
        
        return $this->response->setJSON(['success' => true]);
    }
}