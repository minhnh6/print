					//----------------------- Paging Class start------------------------
					class Pager  
						{  
							function getPagerData($numHits, $limit, $page)  
								{  
									$numHits  = (int) $numHits;  
									$limit    = max((int) $limit, 1);  
									$page     = (int) $page;  
									$numPages = ceil($numHits / $limit);  
									$page = max($page, 1);  
									$page = min($page, $numPages);  
									$offset = ($page - 1) * $limit;  
									$ret = new stdClass;  
									$ret->offset   = $offset;  
									$ret->limit    = $limit;  
									$ret->numPages = $numPages;  
									$ret->page     = $page;  
									return $ret;  
								}
						}  
					//----------------------- Paging Class end ------------------------









							$num_row_template=mysql_num_rows($res_template);
							$page = $_GET['page'];  
	           				$limit = 10;  
							$total=$num_row_template;
							$pager  = Pager::getPagerData($total, $limit, $page);  
							$offset = $pager->offset;  
							$limit  = $pager->limit;  
							$page   = $pager->page;  
							$numPages=$pager->numPages; 

