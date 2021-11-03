const express = require('express')
const app = express()
const mysql = require('mysql');

app.use(express.json());

const db = mysql.createConnection({
    host: "localhost",
    user: "root",
    password: "",
    database: "jobboard"
});

db.connect(function(err) {
    if (err) throw err;
    console.log("Connecté à la base de données MySQL !\n");
});

app.listen(8080, () => {
    console.log("\nServeur à l'écoute !\n")
})

// Listing all users (it works !)

function getAllPeople() {
    app.get('/people', function(req, res) {
        db.query('SELECT * FROM people', function(error, results, fields) {
            if (error) throw error;
            return res.send({ data: results });
        });
    });
}

function getAllCompanies() {
    app.get('/companies', function(req, res) {
        db.query('SELECT * FROM companies', function(error, results, fields) {
            if (error) throw error;
            return res.send({ data: results });
        });
    });
}

function getAllAdvertisements() {
    app.get('/advertisements', function(req, res) {
        db.query('SELECT * FROM advertisements', function(error, results, fields) {
            if (error) throw error;
            return res.send({ data: results });
        });
    });
}

function getAllApplied() {
    app.get('/applied', function(req, res) {
        db.query('SELECT * FROM applied', function(error, results, fields) {
            if (error) throw error;
            return res.send({ data: results });
        });
    });
}

// Retrieve someone (it works !)
function getOnePeople(people_id) {
    app.get('/people/:id', function(req, res) {
        if (!people_id) {
            return res.status(400).send({ message: 'Please provide people_id' });
        }
        db.query('SELECT * FROM people WHERE id = ?', people_id, function(error, results, fields) {
            if (error) throw error;
            return res.send({ data: results[0] });
        });
    });
}

function getOneCompanies(companies_id) {
    app.get('/companies/:id', function(req, res) {
        if (!companies_id) {
            return res.status(400).send({ message: 'Please provide companies_id' });
        }
        db.query('SELECT * FROM companies WHERE id = ?', companies_id, function(error, results, fields) {
            if (error) throw error;
            return res.send({ data: results[0] });
        });
    });
}

function getOneAdvertisements(advertisements_id) {
    app.get('/advertisements/:id', function(req, res) {
        if (!advertisements_id) {
            return res.status(400).send({ message: 'Please provide advertisements_id' });
        }
        db.query('SELECT * FROM advertisements WHERE id = ?', advertisements_id, function(error, results, fields) {
            if (error) throw error;
            return res.send({ data: results[0] });
        });
    });
}

function getOneApplied(applied_id) {
    app.get('/applied/:id', function(req, res) {
        if (!applied_id) {
            return res.status(400).send({ message: 'Please provide applied_id' });
        }
        db.query('SELECT * FROM applied WHERE id = ?', applied_id, function(error, results, fields) {
            if (error) throw error;
            return res.send({ data: results[0] });
        });
    });
}

// Add a user (it works but not with postman)
function addPeople(myName, myFirst_name, myPassword, myEmail, myBirth_date, myCity, myPostal_code, myPhone, myGender, myCv, myWebsite, myPicture) {
    app.post('/people', function(req, res) {
        console.log(people);
        if (!people) {
            return res.status(400).send({ message: 'Please provide people' });
        }

        db.query("INSERT INTO people SET ? ", {
                name: myName,
                first_name: myFirst_name,
                password: myPassword,
                email: myEmail,
                birth_date: myBirth_date,
                city: myCity,
                postal_code: myPostal_code,
                phone: myPhone,
                gender: myGender,
                cv: myCv,
                website: myWebsite,
                picture: myPicture,
            },
            function(error, results, fields) {
                if (error) throw error;
                return res.send({ data: results[0], message: 'New people has been created successfully.' });
            });
    });
}

function addCompanies(myName, myActivities, myAddress, myPostal_code, myCity, mySiret, myPassword, myNumber_employees, myWebsite, myPhone, myEmail, myContact_name) {
    app.post('/companies', function(req, res) {
        console.log(companies);
        if (!companies) {
            return res.status(400).send({ message: 'Please provide companie' });
        }

        db.query("INSERT INTO companies SET ? ", {
                name: myName,
                activities: myActivities,
                address: myAddress,
                postal_code: myPostal_code,
                city: myCity,
                siret: mySiret,
                password: myPassword,
                number_employees: myNumber_employees,
                website: myWebsite,
                phone: myPhone,
                email: myEmail,
                contact_name: myContact_name,
            },
            function(error, results, fields) {
                if (error) throw error;
                return res.send({ data: results[0], message: 'New companie has been created successfully.' });
            });
    });
}

function addAdvertisements(title, description, date, published, contrat_type, wage, working_time) {
    app.post('/advertisements', function(req, res) {
        console.log(advertisements);
        if (!advertisements) {
            return res.status(400).send({ message: 'Please provide advertisement' });
        }

        db.query("INSERT INTO advertisements SET ? ", {
                title: title,
                description: description,
                date: date,
                published: published,
                contrat_type: contrat_type,
                wage: wage,
                working_time: working_time,
            },
            function(error, results, fields) {
                if (error) throw error;
                return res.send({ data: results[0], message: 'New advertisement has been created successfully.' });
            });
    });
}

function addApplied(motivation_people, advertissement_id, people_id) {
    app.post('/applied', function(req, res) {
        console.log(applied);
        if (!applied) {
            return res.status(400).send({ message: 'Please provide applied' });
        }

        db.query("INSERT INTO applied SET ? ", {
                motivation_people: motivation_people,
                advertissement_id: advertissement_id,
                people_id: people_id,
            },
            function(error, results, fields) {
                if (error) throw error;
                return res.send({ data: results[0], message: 'New applied has been created successfully.' });
            });
    });
}

// Update a user (it works but not with postman)
function updatePeople(keyToChange, dataToChange, people_id) {
    app.put('/people', function(req, res) {
        db.query("UPDATE people SET ? = ? WHERE id = ?", [keyToChange, dataToChange, people_id], function(error, results, fields) {
            if (error) throw error;
            return res.send({ message: 'people has been updated successfully.' });
        });
    });
}

function updateCompanies(keyToChange, dataToChange) {
    app.put('/companies', function(req, res) {
        db.query("UPDATE companies SET name = ? WHERE id = ?", [companies, companies_id], function(error, results, fields) {
            if (error) throw error;
            return res.send({ message: 'companie has been updated successfully.' });
        });
    });
}

function updateAdvertisements(keyToChange, dataToChange) {
    app.put('/advertisements', function(req, res) {
        db.query("UPDATE advertisements SET name = ? WHERE id = ?", [advertisements, advertisements_id], function(error, results, fields) {
            if (error) throw error;
            return res.send({ message: 'advertisement has been updated successfully.' });
        });
    });
}

function updateApplied(keyToChange, dataToChange) {
    app.put('/applied', function(req, res) {
        db.query("UPDATE applied SET name = ? WHERE id = ?", [applied, applied_id], function(error, results, fields) {
            if (error) throw error;
            return res.send({ message: 'applied has been updated successfully.' });
        });
    });
}

// Delete a user (it works but not with postman)
function deletePeople(people_id) {
    app.delete('/people', function(req, res) {
        db.query('DELETE FROM people WHERE id = ?', [people_id], function(error, results, fields) {
            if (error) throw error;
            return res.send({ message: 'people has been deleted successfully.' });
        });
    });
}

function deleteCompanies(companies_id) {
    app.delete('/companies', function(req, res) {
        db.query('DELETE FROM companies WHERE id = ?', [companies_id], function(error, results, fields) {
            if (error) throw error;
            return res.send({ message: 'companie has been deleted successfully.' });
        });
    });
}

function deleteAdvertisements(advertisements_id) {
    app.delete('/advertisements', function(req, res) {
        db.query('DELETE FROM advertisements WHERE id = ?', [advertisements_id], function(error, results, fields) {
            if (error) throw error;
            return res.send({ message: 'advertisement has been deleted successfully.' });
        });
    });
}

function deleteApplied(applied_id) {
    app.delete('/applied', function(req, res) {
        db.query('DELETE FROM applied WHERE id = ?', [applied_id], function(error, results, fields) {
            if (error) throw error;
            return res.send({ message: 'applied has been deleted successfully.' });
        });
    });
}