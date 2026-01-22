<?php

namespace App\Models;


use Illuminate\Support\Facades\DB;

class Cart
{
    public $items = null;
    public $totalQte = 0;
    public $totalPrix = 0;

    public function __construct($oldCart)
    {
        if ($oldCart)
        {
            $this->items = $oldCart->items;
            $this->totalQte = $oldCart->totalQte;
            $this->totalPrix = $oldCart->totalPrix;
        }
    }

    public function add($item, $id)
    {
        $storeItem = ['quantite' => 0, 'prix_unitaire' => $item->prix, 'item' => $item];

        if ($this->items)
        {
            if (array_key_exists($id, $this->items))
            {
                $storeItem = $this->items[$id];
            }
        }
        $storeItem['quantite']++;

//        Mise a jour de la qte en bd apres ajout du produit a la facture

            $produit = Produit::find($item->id);
            $value = Produit::where('id', '=', $id)->sum('qte_stock');
            $new_qte_stock = $value - 1;
            $produit->update(['qte_stock' => $new_qte_stock]);

//        Calcul des sommes de produis present sur la facture

            $storeItem['prix_unitaire'] = $item->prix_unitaire;
            $this->items[$id] = $storeItem;

            $this->totalQte++;
            $this->totalPrix += $item->prix_unitaire;

    }

    public function reduceByOne($id)
    {
        $produit = Produit::find($id);
        $this->items[$id]['quantite']--;
        $value = Produit::where('id', '=', $id)->sum('qte_stock');
        $new_qte_stock = $value + 1;
        $produit->update(['qte_stock' => $new_qte_stock]);

        $this->items[$id]['prix_unitaire'] -= $this->items[$id]['item']['prix_unitaire'];
        $this->totalQte--;
        $this->totalPrix -= $this->items[$id]['item']['prix_unitaire'];

        if ($this->items[$id]['quantite'] <= 0)
        {
            unset($this->items[$id]);
        }
    }

    public function removeItem($id)
    {
        $this->totalQte -= $this->items[$id]['quantite'];
        $this->totalPrix -= $this->items[$id]['prix_unitaire'];
        unset($this->items[$id]);
    }
}












