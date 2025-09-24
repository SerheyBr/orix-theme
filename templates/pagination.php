<?php 
    $total_pages =  $total_pages_value ??  1;
    $num_page = $num_page ?? 1
?>
<div class="catalog-content__pagination">
    <div class="catalog-content__pagination-arrow catalog-content__pagination-arrow--prev" data-action="prev">
        <button data-page="<?= max(1, $num_page - 1) ?>" <?= $num_page == 1 ? 'disabled' : '' ?>>
            <svg
                width="23"
                height="10"
                viewBox="0 0 23 10"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
            >
                <path
                d="M0.54038 4.54038C0.286539 4.79422 0.286539 5.20578 0.54038 5.45962L4.67695 9.59619C4.9308 9.85003 5.34235 9.85003 5.59619 9.59619C5.85003 9.34235 5.85003 8.9308 5.59619 8.67696L1.91924 5L5.59619 1.32304C5.85003 1.0692 5.85003 0.657647 5.59619 0.403806C5.34235 0.149965 4.9308 0.149965 4.67695 0.403806L0.54038 4.54038ZM23 4.35L1 4.35V5.65L23 5.65V4.35Z"
                fill="black"
                />
            </svg>
        </button>
    </div>
    <div class="catalog-content__pagination-numbers">
        <?php
            for($i = 1; $i <= $total_pages; $i++){
                
            
                $class_active = $i == $num_page ? 'is-active' : '';
                // $class_active = $i === 1 ? 'is-active' : '';
                echo '<button class="catalog-content__page-num '.$class_active.'" data-page='.$i.'>'.$i.'</button>';
              
            }
        ?>
    </div>
    <div class="catalog-content__pagination-arrow catalog-content__pagination-arrow--next" data-action="next">
        <button data-page="<?= min($total_pages, $num_page + 1) ?>" <?= $num_page == $total_pages ? 'disabled' : '' ?>>
            <svg
                width="23"
                height="10"
                viewBox="0 0 23 10"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
            >
            <path
                fill-rule="evenodd"
                clip-rule="evenodd"
                d="M18.323 9.59624L22.4596 5.45967C22.7135 5.20583 22.7135 4.79427 22.4596 4.54043L18.323 0.403852C18.0692 0.150011 17.6576 0.150011 17.4038 0.403852C17.15 0.657693 17.15 1.06925 17.4038 1.32309L20.4308 4.35005L0 4.35005L0 5.65005L20.4308 5.65005L17.4038 8.677C17.15 8.93084 17.15 9.3424 17.4038 9.59624C17.6576 9.85008 18.0692 9.85008 18.323 9.59624Z"
                fill="#121214"
                />
            </svg>
        </button>
    </div>
</div>