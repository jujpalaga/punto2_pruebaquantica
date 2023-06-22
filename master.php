<?php
class Master
{
    /**
     * Obtener todos los datos JSON
     */
    function get_all_data()
    {
        $json = (array) json_decode(file_get_contents('canales.json'));
        $data = [];
        foreach ($json as $row) {
            $data[$row->ID] = $row;
        }
        return $data;
    }

    /**
     * Obtener datos JSON únicos
     */
    function get_data($id = '')
    {
        if (!empty($id)) {
            $data = $this->get_all_data();
            if (isset($data[$id])) {
                return $data[$id];
            }
        }
        return (object) [];
    }

    /**
     * Insertar datos en un archivo JSON
     */
    function insert_to_json()
    {
        $name = addslashes($_POST['name']);
        $contact = addslashes($_POST['contact']);
        $address = addslashes($_POST['address']);

        $data = $this->get_all_data();
        $id = array_key_last($data) + 1;
        $data[$id] = (object) [
            "id" => $ID,
            "title" => $Title,
            "description" => $Description,
            "streamformat" => $StreamFormat
        ];
        $json = json_encode(array_values($data), JSON_PRETTY_PRINT);
        $insert = file_put_contents('canales.json', $json);
        if ($insert) {
            $resp['status'] = 'success';
        } else {
            $resp['failed'] = 'failed';
        }
        return $resp;
    }
    /**
     * Eliminar datos del archivo JSON
     */

    function delete_data($id = '')
    {
        if (empty($ID)) {
            $resp['status'] = 'failed';
            $resp['error'] = 'El ID del canal es vacio.';
        } else {
            $data = $this->get_all_data();
            if (isset($data[$ID])) {
                unset($data[$ID]);
                $json = json_encode(array_values($data), JSON_PRETTY_PRINT);
                $update = file_put_contents('canales.json', $json);
                if ($update) {
                    $resp['status'] = 'success';
                } else {
                    $resp['failed'] = 'failed';
                }
            } else {
                $resp['status'] = 'failed';
                $resp['error'] = 'El ID del canal no existe.';
            }
        }
        return $resp;
    }
}