<?php
/**
 * FICHIER : detail.php
 * ROLE : Fiche technique dynamique d'un plat avec avis clients pour la réassurance.
 */
require_once 'includes/header.php';

$menus = [
    ['nom' => 'Le Grill Terroir', 'desc' => 'Travers de porc caramélisés (Ribs), frites maison, tomates fraîches et cornichons.', 'prix' => '58,00', 'image' => 'https://images.unsplash.com/photo-1544025162-d76694265947?auto=format&fit=crop&w=600&q=80', 'accroche' => 'Une célébration des saveurs généreuses.'],
    ['nom' => 'Le Pavé Atlantique', 'desc' => 'Pavé de saumon grillé sur sa peau, accompagné de spaghettis de légumes croquants.', 'prix' => '49,00', 'image' => 'https://images.unsplash.com/photo-1519708227418-c8fd9a32b7a2?auto=format&fit=crop&w=600&q=80', 'accroche' => 'La fraîcheur de l\'océan sublimée.'],
    ['nom' => 'La Salade Gourmande', 'desc' => 'Méli-mélo de haricots verts, tomates cerises et bowl de céréales saines.', 'prix' => '42,00', 'image' => 'https://images.unsplash.com/photo-1547592180-85f173990554?auto=format&fit=crop&w=600&q=80', 'accroche' => 'Une composition légère et croquante.'],
    ['nom' => 'Le Festin des Amis', 'desc' => 'Planche à partager composée d\'ailes de poulet rôties, nachos, guacamole et salade.', 'prix' => '52,00', 'image' => 'https://images.unsplash.com/photo-1600891964599-f61ba0e24092?auto=format&fit=crop&w=600&q=80', 'accroche' => 'Le rendez-vous incontournable de la convivialité.'],
    ['nom' => 'Le Bowl Énergie', 'desc' => 'Assiette complète healthy : avocat, pois chiches, radis, tomates cerises et verdure.', 'prix' => '39,00', 'image' => 'https://images.unsplash.com/photo-1512621776951-a57141f2eefd?auto=format&fit=crop&w=600&q=80', 'accroche' => 'Un équilibre parfait entre gourmandise et bien-être.'],
    ['nom' => 'Les Brochettes Orientales', 'desc' => 'Assortiment de brochettes de viande grillée, pommes de terre au four et aubergines.', 'prix' => '46,00', 'image' => 'https://images.unsplash.com/photo-1555939594-58d7cb561ad1?auto=format&fit=crop&w=600&q=80', 'accroche' => 'Un voyage gustatif intense aux parfums d\'épices.']
];

$menu_id = isset($_GET['id']) ? intval($_GET['id']) - 1 : -1;

if ($menu_id < 0 || $menu_id >= count($menus)) {
    echo "<div style='padding: 100px; text-align: center;'><h2 style='color: var(--ocre);'>Menu introuvable</h2></div>";
    require_once 'includes/footer.php'; exit;
}
$menu = $menus[$menu_id];
?>

<main style="padding: 60px 8%; min-height: 70vh;">
    <div style="margin-bottom: 40px;"><a href="menus.php" style="color: #888; text-decoration: none;">← Retour aux menus</a></div>
    <div style="display: flex; flex-wrap: wrap; gap: 50px; align-items: flex-start;">
        <div style="flex: 1; min-width: 300px; max-width: 550px;">
            <div style="border: 1px solid #222; border-radius: 15px; overflow: hidden; border-bottom: 3px solid var(--ocre); height: 400px;">
                <img src="<?php echo $menu['image']; ?>" alt="" style="width: 100%; height: 100%; object-fit: cover; display: block;">
            </div>
        </div>
        <div style="flex: 1.2; min-width: 320px; color: var(--white);">
            <h1 style="color: var(--ocre); font-size: 2.5rem; font-family: 'Playfair Display', serif; margin: 0;"><?php echo $menu['nom']; ?></h1>
            <p style="color: #aaa; font-style: italic; margin-bottom: 30px;">"<?php echo $menu['accroche']; ?>"</p>
            <div style="margin-bottom: 35px; background: #0a0a0a; border: 1px solid #161616; padding: 25px; border-radius: 12px;">
                <p style="color: #888; line-height: 1.7; margin: 0;"><?php echo $menu['desc']; ?></p>
            </div>
            
            <div style="display: flex; align-items: center; gap: 30px; border-top: 1px solid #1a1a1a; padding-top: 30px; margin-bottom: 40px;">
                <div><span style="font-size: 2rem; font-weight: bold;"><?php echo $menu['prix']; ?> €</span></div>
                <div><a href="commande.php?id=<?php echo $menu_id + 1; ?>" style="background: var(--ocre); color: var(--white); text-decoration: none; padding: 15px 35px; border-radius: 8px; font-weight: bold;">Réserver ce menu</a></div>
            </div>

            <section style="margin-top: 40px; padding-top: 20px; border-top: 1px solid #333;">
                <h3 style="color: var(--white); font-size: 1.5rem; margin-bottom: 20px;">Ce qu'ils en pensent</h3>
                <div style="background: #1a1a1a; padding: 20px; border-radius: 15px; margin-bottom: 15px;">
                    <div style="color: var(--ocre); font-size: 0.8rem; margin-bottom: 5px;"><i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i></div>
                    <p style="color: #ccc; font-style: italic; margin: 0;">"Une explosion de saveurs, le rapport qualité-prix est imbattable sur ce menu !"</p>
                    <span style="display: block; margin-top: 10px; color: #777; font-size: 0.8rem;">— Sophie M.</span>
                </div>
                <div style="background: #1a1a1a; padding: 20px; border-radius: 15px;">
                    <div style="color: var(--ocre); font-size: 0.8rem; margin-bottom: 5px;"><i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="far fa-star"></i></div>
                    <p style="color: #ccc; font-style: italic; margin: 0;">"Le dressage est digne d'un grand restaurant. Parfait pour une soirée entre amis."</p>
                    <span style="display: block; margin-top: 10px; color: #777; font-size: 0.8rem;">— Thomas B.</span>
                </div>
            </section>
        </div>
    </div>
</main>
<?php require_once 'includes/footer.php'; ?>