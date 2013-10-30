package se.softwerk.coffee;

/**
 * Created by sam on 10/30/13.
 */
public class User {
    //private variables
    int _id;
    String _user;
    String _pass;

    // Empty constructor
    public User() {

    }

    // constructor
    public User(int id, String country, String year) {
        this._id = id;
        this._user = country;
        this._pass = year;
    }

    // constructor
    public User(String country, String _pass) {
        this._user = country;
        this._pass = _pass;
    }

    public int getId() {
        return this._id;
    }

    // setting country
    public void setId(int id) {
        this._id = id;
    }

    public String getUser() {
        return this._user;
    }

    // setting country
    public void setUser(String user) {
        this._user = user;
    }

    // getting year
    public String getPass() {
        return this._pass;
    }

    // setting year
    public void setPass(String pass) {
        this._pass = pass;
    }

    @Override
    public String toString() {
        return _user + ", " + _pass;
    }
}
