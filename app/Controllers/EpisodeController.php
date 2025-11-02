<?php

/**
 * Episode Controller
 * Handles episode management in admin
 */
class EpisodeController extends Controller {
    
    private $model;
    
    public function __construct() {
        $this->model = new Episode();
    }
    
    public function index() {
        $episodes = $this->model->findAll();
        $this->view('admin/episodes/index', ['episodes' => $episodes]);
    }
    
    public function create() {
        $this->view('admin/episodes/form', ['episode' => null]);
    }
    
    public function store() {
        $data = [
            'episode_number' => $_POST['episode_number'] ?? 1,
            'title' => $_POST['title'] ?? '',
            'description' => $_POST['description'] ?? '',
            'thumbnail_path' => $_POST['thumbnail_path'] ?? '',
            'youtube_url' => $_POST['youtube_url'] ?? '',
            'duration' => $_POST['duration'] ?? '',
            'release_date' => $_POST['release_date'] ?? date('Y-m-d')
        ];
        
        $this->model->create($data);
        $_SESSION['success'] = 'Episode created successfully';
        $this->redirect('/admin/episodes');
    }
    
    public function edit($id) {
        $episode = $this->model->find($id);
        if (!$episode) {
            Response::notFound();
        }
        $this->view('admin/episodes/form', ['episode' => $episode]);
    }
    
    public function update($id) {
        $data = [
            'episode_number' => $_POST['episode_number'] ?? 1,
            'title' => $_POST['title'] ?? '',
            'description' => $_POST['description'] ?? '',
            'thumbnail_path' => $_POST['thumbnail_path'] ?? '',
            'youtube_url' => $_POST['youtube_url'] ?? '',
            'duration' => $_POST['duration'] ?? '',
            'release_date' => $_POST['release_date'] ?? date('Y-m-d')
        ];
        
        $this->model->update($id, $data);
        $_SESSION['success'] = 'Episode updated successfully';
        $this->redirect('/admin/episodes');
    }
    
    public function delete($id) {
        $this->model->delete($id);
        $_SESSION['success'] = 'Episode deleted successfully';
        $this->redirect('/admin/episodes');
    }
}
