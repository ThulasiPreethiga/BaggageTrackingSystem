﻿using System;
using System.IO.Ports;
using System.Threading;
using System.Net;
using System.Text;
using System.Data;
using MySql.Data.MySqlClient; 


namespace Baggage
{
    class Program
    {
        static string ConnectionString = "Server=localhost;Database=Location_db;Uid=root;Pwd=;";


        static void Main(string[] args)
        {
            MySqlConnection connection = new MySqlConnection(ConnectionString);
            MySqlCommand command;
            connection.Open();
            SerialPort sp = new SerialPort();
            sp.BaudRate = 4800;
            sp.PortName = "COM1";
           // Console.WriteLine("Hello @@");
            if(sp.IsOpen)
            {
                sp.Close();
            }
            sp.Open();

            while(true)
            {
                string fromArduino = sp.ReadLine();

                string latitude = "";
                string longitude = "";

                if(fromArduino.Contains(","))
                {
                    string[] LatLong = fromArduino.Split(",");
                    latitude = LatLong[0];
                    longitude = LatLong[1];

                }
                
                
                Console.WriteLine("Latitude " + latitude);
                Console.WriteLine("Longitude " + longitude);
                try
                {
                    command = connection.CreateCommand();
                    command.CommandText = "update location_table set Latitude = @lat, Longitude = @lon where Lno = 1";
                    command.Parameters.AddWithValue("@lat",latitude);
                    command.Parameters.AddWithValue("@lon",longitude);
                    command.ExecuteNonQuery();
                }
                catch
                {
                    throw;
                }
            }
        }
    }
}
