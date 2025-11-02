<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Request;
use App\Core\Response;
use App\Models\Hero;
use App\Helpers\FileUpload;

class AdminHeroController extends Controller
{
    public function index(Request $request, Response $response)
    {
        $heroModel = new Hero();
        $data = ['heroes' => $heroModel->getAllOrdered()];
        $this->render('admin/heroes/index', $data, $response);
    }
    
    public function create(Request $request, Response $response)
    {
        if ($request->isPost()) {
            $data = [
                'slug' => $request->input('slug'),
                'name' => $request->input('name'),
                'description' => $request->input('description'),
                'abilities' => json_encode(explode(',', $request->input('abilities', ''))),
                'display_order' => (int)$request->input('display_order', 0),
            ];
            
            if ($request->hasFile('image')) {
                $upload = FileUpload::upload($_FILES['image'], 'heroes');
                if ($upload['success']) {
                    $data['image'] = $upload['path'];
                }
            }
            
            if ($request->hasFile('video')) {
                $upload = FileUpload::upload($_FILES['video'], 'heroes');
                if ($upload['success']) {
                    $data['video'] = $upload['path'];
                }
            }
            
            $heroModel = new Hero();
            $heroModel->create($data);
            
            $this->redirect('/admin/heroes');
            return;
        }
        
        $this->render('admin/heroes/create', [], $response);
    }
    
    public function edit(Request $request, Response $response, $id)
    {
        $heroModel = new Hero();
        $hero = $heroModel->find($id);
        
        if (!$hero) {
            $response->setStatusCode(404);
            $this->render('errors/404', [], $response);
            return;
        }
        
        if ($request->isPost()) {
            $data = [
                'slug' => $request->input('slug'),
                'name' => $request->input('name'),
                'description' => $request->input('description'),
                'abilities' => json_encode(explode(',', $request->input('abilities', ''))),
                'display_order' => (int)$request->input('display_order', 0),
            ];
            
            if ($request->hasFile('image')) {
                $upload = FileUpload::upload($_FILES['image'], 'heroes');
                if ($upload['success']) {
                    if ($hero['image']) {
                        FileUpload::delete($hero['image']);
                    }
                    $data['image'] = $upload['path'];
                }
            }
            
            if ($request->hasFile('video')) {
                $upload = FileUpload::upload($_FILES['video'], 'heroes');
                if ($upload['success']) {
                    if ($hero['video']) {
                        FileUpload::delete($hero['video']);
                    }
                    $data['video'] = $upload['path'];
                }
            }
            
            $heroModel->update($id, $data);
            $this->redirect('/admin/heroes');
            return;
        }
        
        $this->render('admin/heroes/edit', ['hero' => $hero], $response);
    }
    
    public function delete(Request $request, Response $response, $id)
    {
        $heroModel = new Hero();
        $hero = $heroModel->find($id);
        
        if ($hero) {
            if ($hero['image']) {
                FileUpload::delete($hero['image']);
            }
            if ($hero['video']) {
                FileUpload::delete($hero['video']);
            }
            
            $heroModel->delete($id);
        }
        
        $this->redirect('/admin/heroes');
    }
}
