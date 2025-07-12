CREATE TABLE IF NOT EXISTS transactions (
    id SERIAL PRIMARY KEY,
    compte_id INTEGER REFERENCES comptes(id),
    montant DECIMAL(15,2) NOT NULL,
    type_transaction VARCHAR(20) NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
