<?php
// create class Region

class Region
{
    public $id = null;
    public $name = null;
    public $slug = null;

    private function insert()
    {
        $query = 'INSERT INTO `regions` 
        (`name`, `slug`)
        VALUES (?, ?)
        ';
        DB::insert($query, [$this->name, $this->slug]);
        $this->id = DB::lastInsertId();
    }

    private function update()
    {
        if (empty($this->id)) {
            return null;
        } else {
            $query = 'UPDATE `regions` 
            SET     `name` = ?,
                    `slug` = ?
            WHERE   `id` = ?';

            DB::update($query, [$this->name, $this->slug, $this->id]);
        }
    }

    public function save()
    {
        (isset($this->id)) ? $this->update() : $this->insert();
    }

    public function delete()
    {
        $query = "DELETE FROM `regions` WHERE `id` = ?";

        DB::delete($query, [$this->id]);
    }
}
