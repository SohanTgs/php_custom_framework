<?php

namespace App\Database;

use App\Database\WhereQuery\Where;
use App\Facade\DB;

trait GetRows{
    protected function get($select = null,$isReturn = false){
        $this->buildQuery();
        if (!$select) {
            $select = '*';
        }
        $finalQuery = sprintf('SELECT %s '.$this->query(),$select);
        $result = DB::execute($finalQuery);
        
        if ($isReturn) {
            return $result;
        }
        $this->data = $result;
    }

    protected function paginate($number){
        $pnum          = isset($_GET['pnum']) ? intval($_GET['pnum']) : 1;
        $per_page      = $number;
        $this->buildQuery();
        $countData     = sprintf('SELECT COUNT(*) '.$this->query());
        $total         = DB::getVar($countData);
        $this->query   = '';
        $this->limit($per_page);
        $skip = ($pnum - 1) * $per_page;
        $this->skip($skip);
        $result = $this->get(isReturn:true);
        $this->paginationCall = true;
        $this->pagination = $this->getPageLinks($total, $per_page);
        $this->data = $result;
    }

    private function getPageLinks($total = 0, $limit){
        $page = (isset($_GET['pnum']) && is_numeric($_GET['pnum'])) ? $_GET['pnum'] : 1;

        $totalPages = ceil($total / $limit);

        $prev = $page - 1;
        $next = $page + 1;

        $html = '';
        if ($total >= $limit) {
            $html = "<nav>";
            $html .= '<ul class="pagination justify-content-center">';
            $dNone = $page <= 1 ? 'd-none' : '';
            $html .= '<li class="page-item ' . $dNone . '"> <a class="page-link" href="' . ovolab_query_to_url(['pnum' => $prev]) .'"><i class="las la-angle-left"></i></a></li>';
            $linksPerPage = 6;
            $start        = max(1, $page - floor($linksPerPage / 2));
            $end          = min($totalPages, $start + $linksPerPage - 1);
            $start        = max(1, $end - $linksPerPage + 1);
            for ($i = $start; $i <= $end; $i++) {
                $active = ($page == $i) ? ' active' : '';
                $html .= '<li class="page-item' . $active . '"><a class="page-link" href="' . ovolab_query_to_url(['pnum' => $i]) . '">' . $i . '</a></li>';
            }

            if ($page >= $totalPages) {
                $html .= '<li class="page-item d-none">';
            } else {
                $html .= '<li class="page-item">';
            }

            $html .= '<a class="page-link" href="' . ovolab_query_to_url(['pnum' => $next]) . '"><i class="las la-angle-right"></i></a>
                    </li>
                </ul>
            </nav>';
        }
        return $html;
    }

    protected function first($select = null){
    
        $this->buildQuery();

        if (!$select) {
            
            $select = '*';
        }
        $finalQuery = sprintf('SELECT %s '.$this->query().' LIMIT 1',$select);
        $result = DB::getRow($finalQuery);
        $result = $result ?? 'no-data';
        $this->data = $result;
    }

    protected function find($id){
        $this->buildQuery();

        $query = $this->query();
        $where = new Where;
        $query .= $where->buildQuery($this->query,[
            'column'=>'id',
            'symbol'=>'=',
            'value'=>$id
        ]);

        $finalQuery = sprintf('SELECT * '.$query.' LIMIT 1');
        $result = DB::getRow($finalQuery);
        $result = $result ?? 'no-data';
        $this->data = $result;
    }

    protected function firstOrFail(){
        $this->first();
        if ($this->data == 'no-data') {
            ovolab_abort(404);
        }
    }

    protected function findOrFail($id){
        $this->find($id);
        if ($this->data == 'no-data') {
            ovolab_abort(404);
        }
    }
}