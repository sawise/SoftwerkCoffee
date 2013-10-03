package se.softwerk.coffee;

/**
 * Created by Lukas on 2013-09-26.
 */
public class RegDetails {

    String _username;
    String _password;

    public RegDetails() {

    }

    public RegDetails(String rUsername, String rPassword) {
        this._username = rUsername;
        this._password = rPassword;
    }

    public String getUsername() {
        return _username;
    }

    public void setUsername(String rUsername) {
        this._username = rUsername;
    }

    public String getPassword() {
        return _password;
    }

    public void setPassword(String rPassword) {
        this._password = rPassword;
    }

    @Override
    public String toString() {
        return _username + ", " + _password;
    }
}
