<?php namespace App\Libraries;

class MenuLib
{
    // protected $obj;
    protected $flag;
	protected $mcommon = null;

    public function __construct()
    {
        helper('url');
        $this->mcommon     = new \App\Models\Mcommon();
    }

    public function showMenu()
    {
        $dataMenu = [];
        if(isset($_SESSION['role_id'])){
            $dataMenu = $this->mcommon->getMenuByRoleID($_SESSION['role_id']);
        }

        $menu = array(
            'menus' => array(),
            'parent_menus' => array()
        );
        

        foreach ($dataMenu as $row) {
            $menu['menus'][$row['module_id']] = $row;
            $menu['parent_menus'][$row['module_pid']][] = $row['module_id'];
        }
        $this->flag = false;
        
        $menu = $this->buildMenu(0, $menu);
        return $menu;
    }

    private function buildMenu($parent, $menu, $level = 0)
    {
        $html = "";
        
        if (isset($menu['parent_menus'][$parent])) {
          
            if ($parent === 0) {
                //$html .= "<h3>Menu Utama</h3>";
                $level = 0;
                // $html .= "<ul class='nav' id='side-menu'>";
            } else {
                $level ++;
                $level_str = "second";
                switch ($level) {
                    case 2:
                        $level_str = "third";
                        break;
                    case 3:
                        $level_str = "fourth";
                        break;
                }
                // $html .= sprintf('<ul class="nav nav-%s-level">', $level_str);
                $html .= '<ul aria-expanded="false" class="collapse top_ul">';
            }
            
            foreach ($menu['parent_menus'][$parent] as $menu_id) {
                if ((uri_string(true) == $menu['menus'][$menu_id]['module_url'])
                    OR uri_string(true) == current_url(true)->getSegment(0)
                    OR (current_url(true)->getSegment(1) == $menu['menus'][$menu_id]['mod_group'] 
                    && current_url(true)->getSegment(1) . "/" . current_url(true)->getSegment(2) == $menu['menus'][$menu_id]['module_url'])
                ) {
                    $clsActive = "class='active'";
                }

                $openMenu = "<span>";
                $hideMenu = "<span class='hide-menu'>";
                $hideMenuEnd = "</span>";
                // if ($menu['menus'][$menu_id]['module_url'] == "#" || $menu['menus'][$menu_id]['module_url'] == "/"
                //     || $menu['menus'][$menu_id]['module_url'] == "main/dashboard") {
                //     $hideMenu = "<span class='hide-menu'>";
                //     $hideMenuEnd = "</span>";
                // }

                if (!isset($menu['parent_menus'][$menu_id])) {
                    $html .= "<li>
                                <a href='" . base_url($menu['menus'][$menu_id]['module_url']) . "' class='waves-effect waves-dark'>
                                    <i class='" . $menu['menus'][$menu_id]['mod_icon_cls'] . "'></i> 
                                    " . ($level === 0 ? $hideMenu : $openMenu) . "
                                    " . $menu['menus'][$menu_id]['module_name'] . "
                                    " . $hideMenuEnd . "
                                </a>
                              </li>";
                }
                if (isset($menu['parent_menus'][$menu_id])) {
                    $html .= "<li>
                                <a class='waves-effect waves-dark has-arrow'>
                                    <i class='" . $menu['menus'][$menu_id]['mod_icon_cls'] . "'></i> 
                                    " . $hideMenu . "
                                    " . $menu['menus'][$menu_id]['module_name'] . "
                                    <span class='fa arrow'></span>
                                    " . $hideMenuEnd . "
                                </a>";
                    $html .= $this->buildMenu($menu_id, $menu, $level);
                    $html .= "</li>";
                }
            }
            $html .= "</ul>";
        }
        
        
        return $html;
    }
}
