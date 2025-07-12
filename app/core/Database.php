<?php

class Database
{
    private ?PDO $connection = null;
    
    public function getConnection(): PDO
    {
        // Implémente un pattern Singleton pour la connexion PDO
        // La connexion n'est établie qu'une seule fois par requête
        if ($this->connection === null) {
            try {
                $this->connection = new PDO(DB_DSN, DB_USER, DB_PASS);
                $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $this->connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                throw new Exception("Erreur de connexion à la base de données : " . $e->getMessage());
            }
        }
        
        return $this->connection;
    }
}
