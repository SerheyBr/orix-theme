<?php
    $colors = array(
        'красный' => 'red',
        'белый' => 'white',
        'желтый' => 'yellow',
        'зеленый' => 'green',
        'синик' => 'blue',
        'черный' => 'black',    
    );
    
?>


<div class="sidebar__filter sidebar-filter">
    <div class="sidebar-filter__header">
        <h4 class="sidebar__title title-filter-category"><?php echo $name_taxonomy;?></h4>
        <svg
        width="8"
        height="5"
        viewBox="0 0 8 5"
        fill="none"
        xmlns="http://www.w3.org/2000/svg"
        >
        <path
            d="M3.64645 0.146447C3.84171 -0.0488155 4.15829 -0.0488155 4.35355 0.146447L7.53553 3.32843C7.7308 3.52369 7.7308 3.84027 7.53553 4.03553C7.34027 4.2308 7.02369 4.2308 6.82843 4.03553L4 1.20711L1.17157 4.03553C0.976311 4.2308 0.659728 4.2308 0.464466 4.03553C0.269204 3.84027 0.269204 3.52369 0.464466 3.32843L3.64645 0.146447ZM4 1.5L3.5 1.5L3.5 0.5L4 0.5L4.5 0.5L4.5 1.5L4 1.5Z"
            fill="#232323"
        />
        </svg>
    </div>
    <div class="sidebar-filter__body">
        <div class="sidebar-filter__colors-grid">
            <?php
                if(isset($terms) && !empty($terms) && !is_wp_error($terms)){
                    foreach($terms as $term){
                        $color = $colors[$term->name] ?? '';
                        
                        echo '<label class="label-filter-color">';
                        echo '<input type="checkbox" name="'.$taxonomy.'[]" value="'.esc_attr($term->slug).'"> ';
                        echo '<div class="sidebar-filter__color">';
                        echo '<div class="sidebar-filter__color-exemple" style="background-color:'.$color.'"></div>';
                        echo '<p>'.$term->name.'</p>';
                        echo '</div>';
                        echo '</label>';
                    }
                }
            ?>
        </div>
    </div>
</div>