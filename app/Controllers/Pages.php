<?php namespace App\Controllers;

use CodeIgniter\Controller;

class Pages extends Controller
{
    public function view($page = 'Dashboard')
	{
		if ( ! is_file(APPPATH.'/Views/pages/'.$page.'.php'))
		{
			// Whoops, we don't have a page for that!
			throw new \CodeIgniter\Exceptions\PageNotFoundException($page);
		}

		$data['title'] = ucfirst($page); // Capitalize the first letter
		$this->render_view($page, $data);
	}

	function render_view($page, $data = null)
	{
		echo view('templates/header', $data);
		echo view('pages/'.$page, $data);
		echo view('templates/footer', $data);
	}
}