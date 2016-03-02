<?php
/**
 *
 * author: Nsinm
 * package: jinsi UploadAction.class.php
 * Date: 16/3/2
 * Time: 23:04
 */

class UploadAction extends LiveAction
{
    /**
     * UploadAction constructor.
     */
    function __construct()
    {
        parent::__construct();
    }

    public function index ()
    {
        $this->display();
    }
}