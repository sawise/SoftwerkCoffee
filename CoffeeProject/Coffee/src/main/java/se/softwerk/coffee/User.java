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
    public User(int id, String user, String pass) {
        this._id = id;
        this._user = user;
        this._pass = pass;
    }

    // constructor
    public User(String user, String _pass) {
        this._user = user;
        this._pass = _pass;
    }

    public int getId() {
        return this._id;
    }

    // setting user
    public void setId(int id) {
        this._id = id;
    }

    public String getUser() {
        return this._user;
    }

    // setting user
    public void setUser(String user) {
        this._user = user;
    }

    // getting pass
    public String getPass() {
        return this._pass;
    }

    // setting pass
    public void setPass(String pass) {
        this._pass = pass;
    }

    @Override
    public String toString() {
        return _id + "," +_user + ", " + _pass;
    }
}
