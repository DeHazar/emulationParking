using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Forms;
using System.Net.Http;
using System.Web.Script.Serialization;
using RestSharp;
using RestSharp.Serialization.Json;

namespace OpenAppTerminal
{

        public partial class Form1 : Form
    {
        static String serverIp = "http://192.168.31.33/API/parking/cars/";
        public Form1()
        {
            InitializeComponent();
        }

        private void button1_Click(object sender, EventArgs e)
        {
            int pId = int.Parse(textBox1.Text);
            String carNum = textBox2.Text;
            String Description = textBox3.Text;

            var client = new RestClient(serverIp);
            // client.Authenticator = new HttpBasicAuthenticator(username, password);
            var request = new RestRequest("create.php");
            request.RequestFormat = DataFormat.Json;
            request.AddBody(new { parkingId = pId, carNumber = carNum, description = Description });
            var response = client.Post(request);
            var responseEvent = new JsonDeserializer().Deserialize<ResponseEvent>(response);

            MessageBox.Show(responseEvent.message, "Info Message", MessageBoxButtons.OK, MessageBoxIcon.Exclamation);

            textBox2.Text = "";
            textBox3.Text = "";
         }

    }

    public class ResponseEvent
    {
        public string message { get; set; }
    }
}
