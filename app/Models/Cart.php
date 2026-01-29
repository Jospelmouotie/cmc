<?php

namespace App\Models;

use App\Models\Produit;

class Cart
{
    public $items = [];
    public $totalQte = 0;
    public $totalPrix = 0;

    /**
     * Initialise le panier à partir de l'ancienne session
     */
    public function __construct($oldCart)
    {
        if ($oldCart) {
            // On s'assure de récupérer les données, que ce soit un objet ou un tableau
            if (is_object($oldCart)) {
                $this->items = $oldCart->items ?? [];
                $this->totalQte = $oldCart->totalQte ?? 0;
                $this->totalPrix = $oldCart->totalPrix ?? 0;
            } else {
                $this->items = $oldCart['items'] ?? [];
                $this->totalQte = $oldCart['totalQte'] ?? 0;
                $this->totalPrix = $oldCart['totalPrix'] ?? 0;
            }
        }
    }

    /**
     * Ajoute un produit au panier
     */
    public function add($item, $id)
    {
        // On force l'ID en chaîne pour éviter les problèmes d'indexation
        $id = (string)$id;

        // Structure de l'élément dans le panier
        $storeItem = [
            'qty' => 0,
            'price' => 0, // Prix total pour cette ligne (prix_unitaire * qty)
            'item' => $item
        ];

        // Si l'item existe déjà, on le récupère
        if ($this->items && array_key_exists($id, $this->items)) {
            $storeItem = $this->items[$id];
        }

        // Mise à jour des quantités et prix
        $storeItem['qty']++;

        // On s'assure d'utiliser le bon nom de colonne : prix_unitaire
        $prixUnitaire = $item->prix_unitaire;
        $storeItem['price'] = $prixUnitaire * $storeItem['qty'];

        // Enregistrement dans la liste des items
        $this->items[$id] = $storeItem;

        // Mise à jour des totaux globaux
        $this->totalQte++;
        $this->totalPrix += $prixUnitaire;
    }

    /**
     * Réduit la quantité d'un article de 1
     */
    public function reduceByOne($id)
    {
        $id = (string)$id;

        if (isset($this->items[$id])) {
            $prixUnitaire = $this->items[$id]['item']['prix_unitaire'];

            $this->items[$id]['qty']--;
            $this->items[$id]['price'] -= $prixUnitaire;

            $this->totalQte--;
            $this->totalPrix -= $prixUnitaire;

            // Si la quantité tombe à 0, on supprime l'article
            if ($this->items[$id]['qty'] <= 0) {
                unset($this->items[$id]);
            }
        }
    }

    /**
     * Supprime complètement un article du panier
     */
    public function removeItem($id)
    {
        $id = (string)$id;

        if (isset($this->items[$id])) {
            $this->totalQte -= $this->items[$id]['qty'];
            $this->totalPrix -= $this->items[$id]['price'];
            unset($this->items[$id]);
        }
    }
}
