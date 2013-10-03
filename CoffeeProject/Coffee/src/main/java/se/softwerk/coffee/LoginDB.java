package se.softwerk.coffee;

import android.content.ContentValues;
import android.content.Context;
import android.database.Cursor;
import android.database.sqlite.SQLiteDatabase;
import android.database.sqlite.SQLiteOpenHelper;
import java.util.ArrayList;
import java.util.List;

/**
 * Created by Lukas on 2013-09-25.
 */
public class LoginDB extends SQLiteOpenHelper {

    //Table attributes
    public static final String DATABASE_NAME = "logindatadb";
    public static final int DATABASE_VERSION = 1;
    public static final String TABLE_NAME_CREDENTIALS = "credentials";

    // Data attributes
    public static final String COLUMN_NAME_USERNAME = "username";
    public static final String COLUMN_NAME_PASSWORD = "password";

    private static SQLiteOpenHelper DBHelper;
    private static SQLiteDatabase db;


    public LoginDB(Context context) {
        super(context, DATABASE_NAME, null, DATABASE_VERSION);
        // TODO Auto-generated constructor stub
    }

    @Override
    public void onCreate(SQLiteDatabase db) {
        // TODO Auto-generated method stub

        String dbCreation = "CREATE TABLE IF NOT EXISTS " + TABLE_NAME_CREDENTIALS
                + " ( _id INTEGER PRIMARY KEY AUTOINCREMENT, "
                + COLUMN_NAME_USERNAME + " TEXT NOT NULL, "
                + COLUMN_NAME_PASSWORD + " TEXT NOT NULL " + ");";

        db.execSQL(dbCreation);
    }

    @Override
    public void onUpgrade(SQLiteDatabase db, int oldVersion, int newVersion) {
        // Drop older table if existed
        db.execSQL("DROP TABLE IF EXISTS " + TABLE_NAME_CREDENTIALS);

        // Create tables again
        onCreate(db);
    }

    // Add username + password
    void insertCredentials(RegDetails regDetails){

        SQLiteDatabase sqliteDB = this.getWritableDatabase();

        ContentValues contentValues = new ContentValues();
        contentValues.put(COLUMN_NAME_USERNAME, regDetails.getUsername());
        contentValues.put(COLUMN_NAME_PASSWORD, regDetails.getPassword());

        sqliteDB.insert(TABLE_NAME_CREDENTIALS, null, contentValues);

        sqliteDB.close();
    }

    // List all users
    public List<RegDetails> getAllUsers() {
        List<RegDetails> userList = new ArrayList<RegDetails>();
        // Select All Query
        String selectQuery = "SELECT * FROM " + TABLE_NAME_CREDENTIALS + " ";

        SQLiteDatabase db = this.getWritableDatabase();
        Cursor cursor = db.rawQuery(selectQuery, null);

        // looping through all rows and adding to list
        if (cursor.moveToFirst()) {
            do {
                RegDetails user = new RegDetails();
                user.setUsername(cursor.getString(1));
                user.setPassword(cursor.getString(2));
                // Adding user to list
                userList.add(user);
            } while (cursor.moveToNext());
        }

        // return user list
        return userList;
    }

    // Login function
    public static boolean Login(String username, String password) {
        Cursor c =  db.rawQuery(
                "SELECT * FROM " + TABLE_NAME_CREDENTIALS + " WHERE "
                        + COLUMN_NAME_USERNAME + " = '" + username +"' AND "+ COLUMN_NAME_PASSWORD +" = '"+ password +"'" ,  null);
        if (c.getCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    // Select all users
    public int getRegDetailsCount() {
        String countQuery = "SELECT  * FROM " + TABLE_NAME_CREDENTIALS;

        SQLiteDatabase db = this.getReadableDatabase();

        Cursor cursor = db.rawQuery(countQuery, null);
        int count = cursor.getCount();
        cursor.close();

        return count;
    }

    // Delete all users
    public void deleteAllUsers() {
        SQLiteDatabase db = this.getWritableDatabase();
        db.delete(TABLE_NAME_CREDENTIALS, null, null);
        db.close();
    }

    public void open() {
        // TODO Auto-generated method stub
        db = this.getWritableDatabase();
    }
    public void close() {
        db.close();
    }
}
